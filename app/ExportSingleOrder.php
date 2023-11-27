<?php

namespace App;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;

class ExportSingleOrder implements FromArray, WithHeadings, WithColumnFormatting, ShouldAutoSize, WithEvents {
	use Exportable;

	public function __construct( CharterOrders $order ) {
		$this->order = $order;
	}

	public function array(): array {
		$order = $this->order;

		$passengers = [
			"INF"      => [],
			"Business" => [],
			"Economy"  => [],
		];

		$i = 1;
		foreach ( $order->passengers as $passenger ) {
			$array_def = $passenger->title == "INF" ? "INF" : $order->flight_class;

			$passengers[ $array_def ][] = [
				count( $passengers[ $array_def ] ) + 1,
				$passenger->ticket_number,
				$order->pnr,
				strtoupper( $passenger->title . ': ' . $passenger->first_name . ' ' . $passenger->last_name ),
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
			'Full Name',
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
					'A1:L1',
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
						$event->sheet->getDelegate()->mergeCells( "A$i:L$i" );

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

						$event->sheet->getDelegate()->getStyle( "A$i:L$i" )->applyFromArray( $styleArray );
					} else {
						$columns = [ 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L' ];

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

				$event->sheet->getStyle( 'A1:L1' )->getFill()
				             ->setFillType( \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID )
				             ->getStartColor()->setARGB( 'EFEFEF' );

				$event->sheet->getDelegate()->getStyle( 'A1:L1' )->applyFromArray( $styleArray );
			},
		];
	}
}