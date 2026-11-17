<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $books = $request->user()->books()->orderBy('id')->paginate(10);

        return BookResource::collection($books);
    }

    public function store(StoreBookRequest $request): JsonResponse
    {
        $book = $request->user()->books()->create($request->validated());

        return (new BookResource($book))->response()->setStatusCode(201);
    }

    public function show(Request $request, int $id): BookResource
    {
        return new BookResource($request->user()->books()->findOrFail($id));
    }

    public function update(UpdateBookRequest $request, int $id): BookResource
    {
        $book = $request->user()->books()->findOrFail($id);
        $book->update($request->validated());

        return new BookResource($book);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $request->user()->books()->findOrFail($id)->delete();

        return response()->json(['message' => 'Book deleted.']);
    }
}