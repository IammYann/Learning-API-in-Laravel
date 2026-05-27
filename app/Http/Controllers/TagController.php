<?php
namespace App\Http\Controllers;

use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index() {
        return TagResource::collection(Tag::all());
    }

    public function store(Request $request) {
        $validate = $request->validate([
            'name' => 'required|string|unique:tags',
            'description' => 'nullable|string',
        ]);
        return new TagResource(Tag::create($validate));
    }

    public function show($id)
    {
        return new TagResource(Tag::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255|unique:tags,name,' . $id,
            'description' => 'nullable|string'
        ]);

        $tag->update($validated);
        return new TagResource($tag);
    }

    public function destroy($id)
    {
        Tag::findOrFail($id)->delete();
        return response()->noContent();
    }
}