<?php namespace Modules\User\Requests;

use Dingo\Api\Http\FormRequest;
use App\Scaffold\Traits\HasWithParameter;
use Illuminate\Validation\Rule;
use Modules\User\Models\User;

class PutGenderRequest extends FormRequest
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
            //
            'gender' => [
                'required',
                Rule::in([
                    User::GENDER_MALE,
                    User::GENDER_FEMALE
                ])
            ]
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
