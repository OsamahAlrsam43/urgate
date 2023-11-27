<?php

namespace App;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TravelDownloadExport implements FromArray, WithHeadings, WithColumnFormatting, ShouldAutoSize {
	use Exportable;

	public function __construct( Travel $travel, string $day ) {
		$this->travel = $travel;
		$this->day     = $day;
	}

	public function array(): array {
		$travel = $this->travel;
		$day     = $this->day;

		$orders = $travel->orders()->where('status', '!=', 'canceled')->orderBy( 'id', 'DESC' )->get();

		if ( isset( $day ) and $day != "all" ) {
			$orders = $travel->orders()->where('status', '!=', 'canceled')->where( "type", ( $day - 1 ) )->orderBy( 'id', 'DESC' )->get();
		}

		$passengers = [];
		$i          = 1;
		foreach ( $orders as $order ) {
			foreach ( $order->passengers as $passenger ) {
				$passengers[] = [
					$i,
					$passenger->ticket_number,
					$order->pnr,
					strtoupper( $passenger->title . ': ' . $passenger->first_name . ' ' . $passenger->last_name ),
					$passenger->birth_date,
					$passenger->nationality ? \App\Nationality::find( $passenger->nationality )->name['en'] : '',
					$passenger->passport_number,
					$passenger->passport_expire_date,
					$passenger->class,
					$passenger->price,
					$order->user->company,
					$order->status == 'canceled' ? 'Cancelled' : 'Available'
				];

				$i ++;
			}
		}

		return $passengers;
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
}