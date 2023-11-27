<?php

namespace App\Mail;

use Illuminate\Support\Facades\Storage;
use PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketEmail extends Mailable {
	use Queueable, SerializesModels;

	public $request, $order;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct( $request, $order ) {
		//
		$this->request = $request;
		$this->order   = $order;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 * @throws \Throwable
	 */
	public function build() {
		$request = $this->request;
		$order   = $this->order;

		$hide_prices = $request->hide_prices;
        $status = [
              "TimeLimit"  => "TEMPORARY",
              "Confirmed" => "CONFIRMED",
              "Cancelled" => "CANCELLED"
          ];

		$statusColors = [
			"TimeLimit"  => "info",
			"Confirmed" => "success",
			"Cancelled" => "danger"
		];
      	$flights = $order->flights;
		
		$ticket = view( 'front.charter.ticket', compact( 'order' , 'status' ,'statusColors' , 'flights' , 'hide_prices' ) )->render();
      
		$ticket_name = 'Ticket-' . $order->pnr . '.pdf';
		$ticket_path = 'public/charter/orders/' . $ticket_name;

		$pdfFile = storage_path( 'app/' . $ticket_path );

		$pdf = PDF::loadView( 'front.charter.ticket', compact( 'order', 'status' ,'statusColors' , 'flights', 'hide_prices' ) );
		Storage::put( $ticket_path, $pdf->output() );

		return $this->from( 'reservation@alnkhel.com' )
		            ->subject("Your ticket - " . $order->pnr)
		            ->view( 'user.email.ticket', compact( 'order', 'request', 'ticket' ) )
		            ->attach( $pdfFile, [
			            'as'   => $ticket_name,
			            'mime' => 'application/pdf',
		            ] );
	}
}
