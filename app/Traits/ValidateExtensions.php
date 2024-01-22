<?php
namespace App\Traits;

trait ValidateExtensions
{
 

	/**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  array|string|null  $data
     * @return \Illuminate\Http\JsonResponse
     */
	protected function validateExtension($name)
    {
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $allowed = array('jpeg', 'jpg', 'png','PNG','JPEG','JPG');
            if (!in_array($ext, $allowed)) {
                 return response()->json(["error" => true, "message" => "Elija otro formato de Imagen"], 200);
            }
    }

}