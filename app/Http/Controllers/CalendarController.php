<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\User;
use App\Http\Requests\CalendarRequest;
use App\Models\Doctor;
use App\Models\Especialidad;
use App\Models\Horario;
use Illuminate\Support\Facades\Validator;


class CalendarController extends Controller
{
    public function index()
    {
        $user = backpack_user();
        $especialidades = Especialidad::all();

        if($user->hasRole('Admin') || $user->hasRole("Adminisitrador")){
            $agendas = Agenda::all();
        }else{
            $agendas = Agenda::where('id', $user->id)->get();
        }
       
        return view('calendar', compact('agendas', 'especialidades'));
    }

    public function getDoctors($id){
        $doctores = Doctor::where("especialidad_id", $id)->get();
        $response = ['data' => $doctores];

        return response()->json($response);
    }

    public function getHorasDisponibles($id){
        $horarios = Horario::where("doctor_id", $id)->get();
        $response = ['data' => $horarios];
     
        return response()->json($response);
    }

    public function getEvents(){

        $user = backpack_user();

        if($user->hasRole('Admin') || $user->hasRole("Adminisitrador")){
            $agendas = Agenda::all();
        }else{
            $agendas = Agenda::where('id', $user->id)->get();
        }

        $events = [];
        foreach($agendas as $agenda){
            $horaTermino = strtotime($agenda->hora)->modify('+30 minute');
            $event = array(
                'title' => "Consulta médica",
                'start' => $agenda->fecha. " " .$agenda->hora,
                'end' => date("H:m:s", strtotime($agenda->hora)),
                'doctor' => $agenda->doctor->nombre,
                'especialidad' => $agenda->doctor->especialidad->nombre,
            );
            array_push($events, $event);
        }

        $response = ['data' => $events];
        dd($response);
        return response()->json($response);
    }

    public function store(Request $request){
        $rules =[
            'fecha' => 'required|date',
            'hora' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = json_encode($validator->errors(), JSON_UNESCAPED_SLASHES);
            return response($errors, 400);
        }

        $agenda = Agenda::create([
            'user_id' => backpack_user()->id,
            'doctor_id' => $request->doctor_id,
            'fecha' => date('Y-m-d', strtotime($request->fecha)),
            'hora' => $request->hora,
            'duracion' => Agenda::DURACION,
        ]);
    }

    /* public function store(Request $request){

        $rules =[
            'first_name' => 'required|min:3|max:255',
            'last_name' => 'required|min:3|max:255',
            'email' => 'required|email',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'service_hash' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = json_encode($validator->errors(), JSON_UNESCAPED_SLASHES);
            return response($errors, 400);
        }


        $serviceBooking = new ServiceBooking;

        $service = Service::where('hash', $request->service_hash)->first();

        $customer = Customer::where('email', $request->email)->first();
        if(!$customer){
            $customer = Customer::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'uid' => '123456',
                'created_by_user_id' => $service->user_id,
            ]);
        }

        $formula = [
            'service_name' => $service->name,
            'service_duration' => $service->duration,
            'service_unit' => $service->unit,
            'service_currency_id' => $service->currency_id,
            'service_hash' => $service->hash,
            'service_user_id' => $service->user_id,
            'service_calendar_color' => $service->calendar_color,
            'customer_first_name' => $request->first_name,
            'customer_last_name' => $request->last_name,
            'customer_email' => $request->email,
        ];

        $start_at = $request->date." ".$request->start_time;
        $ends_at = $request->date." ".$request->end_time;
        
        $serviceBooking->make([
                'starts_at' => $start_at, 
                'ends_at' => $ends_at, 
                'price' => $service->price, 
                'quantity' => 1, 
                'currency' => $service->currency->code, 
                'formula' => $formula,
                'notes' => $request->comment,
            ])
            ->customer()->associate($customer)
            ->bookable()->associate($service)
            ->save();
    } */

    /* public function events($hash = ""){

        if($serviceBookings = Service::where('hash', $hash)->first()){
            $serviceBookings = $serviceBookings->getBookingModel()->where('canceled_at', null)->get();
        }else{
            $serviceBookings = ServiceBooking::where('canceled_at', null)->get();
        }
        
        $events = [];
        foreach($serviceBookings as $serviceBooking){
            $service = $serviceBooking->bookable;
            $customer = $serviceBooking->customer;
            $event = array(
                'title' => $service->name,
                'start' => $serviceBooking->starts_at,
                'end' => $serviceBooking->ends_at,
                'color' => $service->calendar_color,
                'customerFirstName' => $customer->first_name,
                'customerLastName' => $customer->last_name,
                'customerEmail' => $customer->email,
                'start_at' => $serviceBooking->starts_at,
                'ends_at' => $serviceBooking->ends_at,
                'comment' => $serviceBooking->notes,
            );
            array_push($events, $event);
        }
        $response = json_encode($events);
        return response($response, 200);
    } */
}
