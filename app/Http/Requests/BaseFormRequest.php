<?php

namespace App\Http\Requests;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class BaseFormRequest extends FormRequest
{
    use ApiResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->hasFile('picture')) {
            $validation = 'required|mimes:jpeg,bmp,png,gif,svg,pdf';
            return [
                'file' => $validation,
                'path' => 'nullable|string',
            ];
        }
        if($this->hasFile('video')){
            $validation = 'required|mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv';
            return [
                'file' => $validation,
                'path' => 'nullable|string',
            ];
        }
        return [];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->badRequestResponse(data: $validator->errors()));
    }

    protected function passedValidation()
    {
        if ($this->hasFile('picture')) {
            // Get the uploaded file
            $picture = $this->file('picture');

            // Define the file path and name
            $file = Str::random(10).$picture->getClientOriginalName();
            $path = $this->file('picture')->move('root/picture',$file);

            if ($path) {
                $this->merge([
                    'path'   => $path
                ]);
            } else {
                throw ValidationException::withMessages([
                    'file' => 'The file failed to upload.',
                ]);
            }
        }

        if ($this->hasFile('video')) {
            // Get the uploaded file
            $video = $this->file('video');

            // Define the file path and name
            $video = Str::random(10).$video->getClientOriginalName();
            $path = $this->file('video')->move('root/video',$video);

            if ($path) {
                $this->merge([
                    'path'   => $path
                ]);
            } else {
                throw ValidationException::withMessages([
                    'file' => 'The file failed to upload.',
                ]);
            }
        }
    }


    public function validated($key = null, $default = null)
    {
        $validatedData = parent::validated($key, $default);

        // Custom logic to modify the validated data
        if ($this->has('path')) {
            $validatedData['path'] = $this->input('path');
        }

        return $validatedData;
    }

    public function lampiranRules(): array
    {
        return [
            'name_file' => 'required|string',
            'type_file'             => 'required|string',
            'path'    => 'required|string',
        ];
    }
}
