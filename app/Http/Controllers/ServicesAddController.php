<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Service;


class ServicesAddController extends Controller
{
    public function execute(Request $request){

    	if($request->isMethod('post')){

    		$input = $request->except('_token');

    		$massages = [
    			'required'=>"Поле :attribute обязательно к заполнению"
    		];

    		$validator = Validator::make($input, [
				'name'=>'required|max:255',
				'text'=>'required',
				'icon'=>'required'
    		], $massages);

    		if($validator->fails()){
    			return redirect()->route('servicesAdd')->withErrors($validator)->withInput();
    		}

    		if($request->hasFile('images')){
	    		$file = $request->file('images');
	    		$input['images'] = $file->getClientOriginalName();
	    		/*копируем загружаемый файл в директорию /assets/img*/
	    		$file->move(public_path().'/assets/img', $input['images']);
	    	}

	    	$service = new Service();

	    	$service->fill($input);
	    	if($service->save()){
	    		return redirect('admin')->with('status','Сервис добавлен');
	    	}

    	}

		if(view()-> exists('admin.services_add')){
			$data = [
					'title' =>'Новый сервис'
					];
		return view('admin.services_add',$data);
		}
		abort(404);
	}
}
