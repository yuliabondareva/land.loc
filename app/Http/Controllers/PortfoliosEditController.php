<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Portfolio;
use Validator;

class PortfoliosEditController extends Controller
{
    public function execute(Portfolio $portfolio,Request $request){

        if($request->isMethod('delete')){
            $portfolio->delete();
            return redirect('admin')->with('status','Портфолио удалено');;
        }


    	if($request->isMethod('post')){

    		$input = $request->except('_token');

    		$massages = [
    			'required'=>"Поле :attribute обязательно к заполнению",
    		];

    		$validator = Validator::make($input, [
				'name'=>'required|max:255',
                'images'=>'required',
                'filter'=>'required'
    		], $massages);

    		if($validator->fails()){
    			return redirect()->route('portfoliosEdit', ['portfolio'=>$input['id']])
    							 ->withErrors($validator);
    		}

    		if($request->hasFile('images')){
	    		$file = $request->file('images');
	    		$input['images'] = $file->getClientOriginalName();
	    		/*копируем загружаемый файл в директорию /assets/img*/
	    		$file->move(public_path().'/assets/img', $input['images']);
	    	} else {
	    		$input['images'] = $input['old_images'];
	    	}


	    	unset($input['old_images']);

	    	$portfolio->fill($input);
	    	if($portfolio->update()){
	    		return redirect('admin')->with('status','Портфолио обновлено');
	    	}

    	}
    	
    	$old = $portfolio->toArray();
    	if(view()->exists('admin.portfolios_edit')){
    		$data = [
    				'title'=>'Редактирование портфолио -'.$old['name'],
    				'data'=> $old
    				];
    		return view('admin.portfolios_edit',$data);
    	}
    }
}
