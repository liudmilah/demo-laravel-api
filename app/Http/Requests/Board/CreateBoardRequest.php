<?php
declare(strict_types=1);

namespace App\Http\Requests\Board;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="CreateBoardRequest",
 *     description="Create board",
 *     @OA\JsonContent(
 *         @OA\Property(property="name", type="string")
 *      )
 * )
 */
final class CreateBoardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // todo change
    }

    public function rules(): array
    {
        return [
            'name' => 'bail|required|max:100', // todo unique
        ];
    }
}
