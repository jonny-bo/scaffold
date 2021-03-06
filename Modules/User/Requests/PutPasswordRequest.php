<?php namespace Modules\User\Requests;

use App\Scaffold\Traits\HasWithParameter;
use Dingo\Api\Http\FormRequest;

class PutPasswordRequest extends FormRequest
{
    use HasWithParameter;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return  bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        return [
            'oldPassword'           => 'required',
            'password'              => 'required|min:5|confirmed',
            'password_confirmation' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            //
        ];
        // return __('some_u18n.fields');
    }
}
