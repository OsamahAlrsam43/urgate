<?php

namespace App;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DownloadExport implements FromArray, WithHeadings, WithColumnFormatting, ShouldAutoSize, WithEvents {
	use Exportable;

	public function __construct( Charter $charter, $user ) {
		$this->charter = $charter;
		$this->user    = $user;
	}

	public function array(): array {
		$charter = $this->charter;
		$user    = $this->user;

		$ordersQuery = $charter->orders()->where( 'status', '!=', 'cancelled' )->orderBy( 'id', 'DESC' );

		if($user and $user != 0) {
			$ordersQuery->where("user_id", $user);
		}

		$orders = $ordersQuery->get();

		$passengers = [
			"INF"      => [],
			"Business" => [],
			"Economy"  => [],
		];

		$i = 1;
		foreach ( $orders as $order ) {
			foreach ( $order->passengers as $passenger ) {
				$array_def = $passenger->title == "INF" ? "INF" : $order->flight_class;

				$passengers[ $array_def ][] = [
					count( $passengers[ $array_def ] ) + 1,
					join(" - ", json_decode($passenger->ticket_number, true)),
					$order->pnr,
					$passenger->title,
					strtoupper( $passenger->first_name  ),
					strtoupper( $passenger->last_name ),
					$passenger->birth_date,
					$passenger->nationality ? \App\Nationality::find( $passenger->nationality )->name['en'] : '',
					$passenger->passport_number,
					$passenger->passport_expire_date,
					$order->flight_class,
					$passenger->price,
					$order->user->company,
					$order->status == 'cancelled' ? 'Cancelled' : 'Available'
				];

				$i ++;
			}
		}


		// Titles Rows
		$BusinessRow = [ [ 'Business' ] ];
		$EconomyRow  = [ [ 'Economy' ] ];
		$INFRow      = [ [ 'INF' ] ];

		$output = array_merge(
			count( $passengers['Business'] ) ? $BusinessRow : [],
			$passengers['Business'],
			count( $passengers['Economy'] ) ? $EconomyRow : [],
			$passengers['Economy'],
			count( $passengers['INF'] ) ? $INFRow : [],
			$passengers['INF']
		);

		return $output;
	}

	public function headings(): array {
		return [
			'#',
			'Ticket No',
			'PNR',
			'Title',
			'First Name',
			'Last Name',
			'Birth Date',
			'Nationality',
			'Passport Number',
			'Passport Expire Date',
			'Class',
			'Price',
			'Agent',
			'Status',
		];
	}

	public function columnFormats(): array {
		return [
			'E' => NumberFormat::FORMAT_TEXT,
			'H' => NumberFormat::FORMAT_TEXT,
		];
	}

	/**
	 * @return array
	 */
	public function registerEvents(): array {
		return [
			AfterSheet::class => function ( AfterSheet $event ) {
				$event->sheet->styleCells(
					'A1:N1',
					[
						'alignment' => [
							'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
							'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
						],
						'font'      => [
							'size' => 14,
							'bold' => true,
						]
					]
				);

				$styleArray = [
					'borders' => [
						'outline' => [
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							'color'       => [ 'argb' => '333333' ],
						]
					]
				];

				$event->sheet->getDelegate()->getRowDimension( 1 )->setRowHeight( 30 );

				$highest_row = $event->sheet->getDelegate()->getHighestRow();
				for ( $i = 1; $i <= $highest_row; $i ++ ) {
					$value = $event->sheet->getDelegate()->getCellByColumnAndRow( 1, $i )->getValue();
					if ( in_array( $value, [ 'Business', 'Economy', 'INF' ] ) ) {
						$event->sheet->getDelegate()->mergeCells( "A$i:N$i" );

						$event->sheet->getStyle( "A$i:L$i" )->getFill()
						             ->setFillType( \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID )
						             ->getStartColor()->setARGB( 'FBF98C' );

						$event->sheet->styleCells(
							"A$i:L$i",
							[
								'alignment' => [
									'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
								],
								'font'      => [
									'size' => 16,
									'bold' => true,
								]
							]
						);

						$event->sheet->getDelegate()->getStyle( "A$i:N$i" )->applyFromArray( $styleArray );
					} else {
						$columns = [ 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N' ];

						$event->sheet->styleCells(
							"A$i",
							[
								'font' => [
									'size' => 16,
									'bold' => true,
								]
							]
						);

						foreach ( $columns as $column ) {
							$event->sheet->getDelegate()->getStyle( "$column$i" )->applyFromArray( $styleArray );

							$event->sheet->styleCells(
								"$column$i",
								[
									'alignment' => [
										'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
									],
									'font'      => [
										'size' => 12,
									]
								]
							);
						}
					}
				}

				$event->sheet->getStyle( 'A1:N1' )->getFill()
				             ->setFillType( \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID )
				             ->getStartColor()->setARGB( 'EFEFEF' );

				$event->sheet->getDelegate()->getStyle( 'A1:N1' )->applyFromArray( $styleArray );
			},
		];
	}
}