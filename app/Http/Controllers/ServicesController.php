<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Spa;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    public function servicesView(Request $request) {
        //$services = Services::find(1);
        //$spaIds = [1, 2];
        //$services->spa()->attach($spaIds);
        //return $services->spa;
        //return $spa->services;
        //return Spa::with('services')->find(2);

        $user = Auth::user();
        $query = Services::where('owner_id', $user->id);
        $spa = Spa::where('owner_id', $user->id)->get();

        if($request->has('reset_button')) {
            return redirect()->route('owner/services');
        }

        if($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
        }

        $services = $query->paginate(15);

        return view('owner.services', [
            "services" => $services,
            "spa" => $spa
        ]);
    }

    public function addServices(Request $request) {
        /*   dd($request->all()); */
          $servicesImage = $request->file('picture');
  
          if ($servicesImage) {
              try {
                  $serviesFilename = 'picture' . uniqid() . '.' . $servicesImage->getClientOriginalExtension();         
                  $uploadPath = public_path('/fileupload/services/');
                  $servicesImage->move($uploadPath, $serviesFilename);
                  Image::Make($uploadPath . $serviesFilename)
                  ->resize(500,600)->save(); 
              } catch (Exception $ex) {
                  // Handle exception if needed
                  dd($ex->getMessage());
              }
          }
          $user = Auth::user();
          $services = new Services();
          $services->owner_id = $user->id;
          $services->name = $request->name;
          $services->description = $request->description;
          $services->price = $request->price;
          $services->picture = $serviesFilename;
          $services->save();
  
          session()->flash('services_save', true);
          return redirect()->back();  
      }


    public function updateService(Request $request) {
    
      if($request->has('id')) {
        $servicesId = $request->input('id');
        $service = Services::find($servicesId);
        $service->name = $request->input('name');
        $service->description = $request->input('description');
        $service->price = $request->input('price');
     

            if($request->hasFile('picture')) {
                $serviceProfile = $request->file('picture');
                $serviceFileName = 'picture' .uniqid() . '.' . $serviceProfile->getClientOriginalExtension();
                $uploadPath = public_path('/fileupload/services/');
                $serviceProfile->move($uploadPath, $serviceFileName);
                
                Image::make($uploadPath . $serviceFileName)
                        ->resize(500,600)
                        ->save();

                if($service->picture != $serviceFileName) {
                    $old_picure = $uploadPath . $service->picture;

                    if(file_exists($old_picure)) {
                        unlink($old_picure);
                    }

                    
                    $service->picture = $serviceFileName;
                
                }     
            }
            session()->flash('services_update', true);
            $service->save(); 
         }  
         return redirect()->back();
    }
    

   /*  public function assignSpa(Request $request) {
   
       if ($request->has('id') && $request->has('spa_id')) {
            $services_id = $request->input('id');
            $spa_id = $request->input('spa_id');

            $services = Services::find($services_id);
            $services->spa_id = $spa_id;

            session()->flash('assign_spa', true);   
            $services->save();
        }
         return redirect()->back();
    } */

    public function assignSpa(Request $request)
    {
        if ($request->has('id') && $request->has('spa')) {
            $services_id = $request->input('id');
            DB::table('services_spa')->where('services_id',$services_id)->delete();
            
            $services = Services::find($services_id);
            $spaIds = $request->spa;
            $services->spa()->attach($spaIds);
            
            
            
            // $spa_id = $request->input('spa_id');

            // $services = Services::find($services_id);
            // $services->spa_id = $spa_id;

            // session()->flash('assign_spa', true);   
            // $services->save();
        }
         return redirect()->back();
    }
    
    
}

