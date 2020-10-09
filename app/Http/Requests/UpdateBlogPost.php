<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

use Illuminate\Support\Str;

class UpdateBlogPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $post = $this->route('post');
        if ($this->user()->can('update-post', $post)) {
            return true;
        } else {
            return redirect()
                ->route('posts.edit', $post->slug)
                ->withErrors(['Unauthorized', 'You need permission to edit posts by ' . $post->user->name])
                ->withInput();
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $post = $this->route('post');
        return [
            "title" => ["required", Rule::unique('posts')->ignore($post->id), "max:255"],
            "description" => "required"
        ];
    }

    // https://laravel.com/docs/8.x/validation#prepare-input-for-validation
    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug(
                date("Ymd") . "-" . Str::limit($this->title, 55),
                "-"
            )
        ]);
    }
}
