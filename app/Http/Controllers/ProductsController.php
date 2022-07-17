<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{

    public function getProducts(Request $request)
    {
        $groupId = intval($request->input('group'));
        $parentGroup = $groupId === 0 ? null : \App\Group::find($groupId);

        if ($groupId === 0) {
            $products = \App\Product::all();
            $groups = \App\Group::where('id_parent', 0)->get();
        } else {
            $groups = \App\Group::where('id_parent', $groupId)->get();
            $descendants = $this->getGroupDescendants($groupId);
            $products = \App\Product::whereIn('id_group', array_merge($descendants, [$groupId]))->get();
        }

        return view('products', [
            'products' => $products,
            'groups' => $groups,
            'groupId' => $groupId,
            'parentGroup' => $parentGroup,
        ]);
    }

    public function getGroupDescendants($groupId)
    {
        $children = \App\Group::where('id_parent', $groupId)->get();
        $idDescendants = [];
        foreach ($children as $child) {
            $idDescendants = array_merge($idDescendants, [$child->id]);
            $idDescendants = array_merge($idDescendants, $this->getGroupDescendants($child->id));
        }
        return $idDescendants;
    }

}
