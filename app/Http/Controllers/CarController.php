<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendRequest;
use App\Models\CarMark;
use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CarController extends Controller
{
    public function index()
    {
        $marks = CarMark::all();
        $models = CarModel::with('mark')->get();

        return view('welcome', ['marks'=> $marks, 'models' => $models]);
    }

    public function getCarModels(Request $request)
    {
        $markId = $request->input('mark_id');
        $models = CarModel::where('car_mark_id', $markId)->get();

        return $models;
    }

    public function send(SendRequest $request)
    {
        $carMark = CarMark::find($request->car_mark);
        $carModel = CarModel::find($request->car_model);

        $data = [
            'carMark' => $carMark->name,
            'carModel' => $carModel->name,
        ];

        Mail::send('emails.car', $data, function($message) use ($request) {
            $message->to(config('mail.admin_email'), 'Пользователь')
                ->subject('Выбранный автомобиль');
        });

        return view('welcome');
    }
}
