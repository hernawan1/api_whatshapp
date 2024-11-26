<?php

namespace App\Http\Requests;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Validator;

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
            $validation = ['required'];
            $picture = $this->file('picture');
            $file = Str::random(10).$picture->getClientOriginalName();
            $path = $this->file('picture')->move('root/picture',$file);

            return [
                'name_file'      => $file,
                'type_file'      => 'image',
                'path'           => $path,
            ];
        }
        if($this->hasFile('video')){
            $validation = ['required'];
            $picture = $request->file('video');
            $file = Str::random(10).$picture->getClientOriginalName();
            $path = $this->file('video')->move('root/video',$file);

            return [
                'name_file'      => $file,
                'type_file'      => 'video',
                'path'           => $path,
            ];
        }
        return [];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->badRequestResponse(data: $validator->errors()));
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

    protected function passedValidation()
    {
        if ($this->hasFile('picture')) {
            // Get the uploaded file
            $picture = $this->file('picture');

            // Define the file path and name
            $path = 'root/picture/' . Str::random(10).$picture->getClientOriginalName();

            if ($path) {
                $this->merge([
                    'path'   => $path,
                ]);
            } else {
                throw ValidationException::withMessages([
                    'file' => 'The file failed to upload.',
                ]);
            }
        }
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
