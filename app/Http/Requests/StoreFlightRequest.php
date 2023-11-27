<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFlightRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name.*' => 'required',
            'price.*' => 'bail|required|integer|min:0',
            'ticket' => 'required',
            'trip_information.*' => 'required',
            'trip_information.common.going.start_date' => 'required',
            'trip_information.common.going.end_date' => 'required',
            'trip_information.common.coming.start_date' => 'required_if:ticket,RoundTrip',
            'trip_information.common.coming.end_date' => 'required_if:ticket,RoundTrip',
            'trip_information.common.going.from_country' => 'required',
            'trip_information.common.going.to_country' => 'required',
            'trip_information.en.going.from_airport' => 'required',
            'trip_information.ar.going.from_airport' => 'required',
            'trip_information.en.coming.from_airport' => 'required_if:ticket,RoundTrip',
            'trip_information.ar.coming.from_airport' => 'required_if:ticket,RoundTrip',
            'trip_information.en.going.to_airport' => 'required',
            'trip_information.ar.going.to_airport' => 'required',
            'trip_information.en.coming.to_airport' => 'required_if:ticket,RoundTrip',
            'trip_information.ar.coming.to_airport' => 'required_if:ticket,RoundTrip',
            'trip_information.en.going.from_city' => 'required',
            'trip_information.ar.going.from_city' => 'required',
            'trip_information.en.coming.from_city' => 'required_if:ticket,RoundTrip',
            'trip_information.ar.coming.from_city' => 'required_if:ticket,RoundTrip',
            'trip_information.en.going.to_city' => 'required',
            'trip_information.ar.going.to_city' => 'required',
            'trip_information.en.coming.to_city' => 'required_if:ticket,RoundTrip',
            'trip_information.ar.coming.to_city' => 'required_if:ticket,RoundTrip',
            'trip_information.en.going.from_lounge' => 'required',
            'trip_information.ar.going.from_lounge' => 'required',
            'trip_information.en.coming.from_lounge' => 'required_if:ticket,RoundTrip',
            'trip_information.ar.coming.from_lounge' => 'required_if:ticket,RoundTrip',
            'trip_information.en.going.to_lounge' => 'required',
            'trip_information.ar.going.to_lounge' => 'required',
            'trip_information.en.coming.to_lounge' => 'required_if:ticket,RoundTrip',
            'trip_information.ar.coming.to_lounge' => 'required_if:ticket,RoundTrip',
            'aircraft_operator.*' => 'required',
            'airplane_type.*' => 'required',
            'class.*' => 'required',
            'seat_type.*' => 'required',
            'electric_port.*' => 'required',
            'display.*' => 'required',
            'aircraft_logo' => 'required|image',
            'thumb' => 'required|image',
            'cancellation_before_departure' => 'required',
            'cancellation_before_departure_price' => 'required',
            'cancellation_after_departure' => 'required',
            'cancellation_after_departure_price' => 'required',
            'absence' => 'required',
            'absence_price' => 'required',
            'change_before_departure' => 'required',
            'change_before_departure_price' => 'required',
            'change_after_departure' => 'required',
            'change_after_departure_price' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'name.en.required' => 'The english name field is required.',
            'name.ar.required' => 'The arabic name field is required.',
            'price.adult.required' => 'The price for adult field is required.',
            'price.children.required' => 'The price for children field is required.',
            'price.baby.required' => 'The price for baby field is required.',
            'price.adult.integer' => 'The price for adult field must be a number.',
            'price.children.integer' => 'The price for children field must be a number.',
            'price.baby.integer' => 'The price for baby field must be a number.',
            'price.adult.min' => 'The price for adult field must be at least 0.',
            'price.children.min' => 'The price for children field must be at least 0.',
            'price.baby.min' => 'The price for baby field must be at least 0.',
            'ticket.required' => 'The ticket field is required.',
            'trip_information.common.going.start_date.required' => 'The  start date field is required.',
            'trip_information.common.going.end_date.required' => 'The  end date field is required.',
            'trip_information.common.coming.start_date.required_if' => 'The start date field is required.',
            'trip_information.common.coming.end_date.required_if' => 'The end date field is required.',
            'trip_information.common.going.from_country.required' => 'The from country field is required.',
            'trip_information.common.going.to_country.required' => 'The to country field is required.',
            'trip_information.en.going.from_airport.required' => 'The from airport field is required.',
            'trip_information.ar.going.from_airport.required' => 'The from airport field is required.',
            'trip_information.en.coming.from_airport.required_if' => 'The from airport field is required.',
            'trip_information.ar.coming.from_airport.required_if' => 'The from airport field is required.',
            'trip_information.en.going.to_airport.required' => 'The to airport field is required.',
            'trip_information.ar.going.to_airport.required' => 'The to airport field is required.',
            'trip_information.en.coming.to_airport.required_if' => 'The to airport field is required.',
            'trip_information.ar.coming.to_airport.required_if' => 'The to airport field is required.',
            'trip_information.en.going.from_city.required' => 'The from city field is required.',
            'trip_information.ar.going.from_city.required' => 'The from city field is required.',
            'trip_information.en.coming.from_city.required_if' => 'The from city field is required.',
            'trip_information.ar.coming.from_city.required_if' => 'The from city field is required.',
            'trip_information.en.going.to_city.required' => 'The to city field is required.',
            'trip_information.ar.going.to_city.required' => 'The to city field is required.',
            'trip_information.en.coming.to_city.required_if' => 'The to city field is required.',
            'trip_information.ar.coming.to_city.required_if' => 'The to city field is required.',
            'trip_information.en.going.from_lounge.required' => 'The from lounge field is required.',
            'trip_information.ar.going.from_lounge.required' => 'The from lounge field is required.',
            'trip_information.en.coming.from_lounge.required_if' => 'The from lounge field is required.',
            'trip_information.ar.coming.from_lounge.required_if' => 'The from lounge field is required.',
            'trip_information.en.going.to_lounge.required' => 'The to lounge field is required.',
            'trip_information.ar.going.to_lounge.required' => 'The to lounge field is required.',
            'trip_information.en.coming.to_lounge.required_if' => 'The to lounge field is required.',
            'trip_information.ar.coming.to_lounge.required_if' => 'The to lounge field is required.',
            'aircraft_operator.en.required' => 'The english aircraft operator field is required.',
            'aircraft_operator.ar.required' => 'The arabic aircraft operator field is required.',
            'airplane_type.en.required' => 'The english airplane type field is required.',
            'airplane_type.ar.required' => 'The arabic airplane type field is required.',
            'class.en.required' => 'The english class field is required.',
            'class.ar.required' => 'The arabic class field is required.',
            'seat_type.en.required' => 'The english seat type field is required.',
            'seat_type.ar.required' => 'The arabic seat type field is required.',
            'electric_port.en.required' => 'The english electric port field is required.',
            'electric_port.ar.required' => 'The arabic electric port field is required.',
            'display.en.required' => 'The english display field is required.',
            'display.ar.required' => 'The arabic display field is required.',
        ];
    }
}
