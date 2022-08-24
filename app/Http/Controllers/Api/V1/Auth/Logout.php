<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/api/v1/auth/logout",
 *     tags={"Auth"},
 *     summary="Logout user",
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     )
 * )
 */
final class Logout extends \App\Http\Controllers\Controller
{
    public function __invoke(Request $request): void
    {
        $request->user()->currentAccessToken()->delete();
    }
}
