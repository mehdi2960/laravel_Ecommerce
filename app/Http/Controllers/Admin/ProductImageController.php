<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductImageController extends Controller
{
    public function upload($primaryImage, $images)
    {
        $fileNamePrimaryImage = generateFileName($primaryImage->getClientOriginalName());

        $primaryImage->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $fileNamePrimaryImage);

        $fileNameImages = [];
        foreach ($images as $image) {
            $fileNameImage = generateFileName($image->getClientOriginalName());

            $image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $fileNameImage);

            array_push($fileNameImages,  $fileNameImage);
        }

        return ['fileNamePrimaryImage' => $fileNamePrimaryImage, 'fileNameImages' => $fileNameImages];
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit_images', compact('product'));
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'image_id' => 'required|exists:product_images,id'
        ]);

        ProductImage::destroy($request->image_id);

        alert()->success('تصویر محصول مورد نظر حدف شد', 'باتشکر');
        return redirect()->back();
    }

    public function setPrimary(Request $request, Product $product)
    {
        $request->validate([
            'image_id' => 'required|exists:product_images,id'
        ]);

        $productImage = ProductImage::findOrFail($request->image_id);
        $product->update([
            'primary_image' => $productImage->image
        ]);
        alert()->success('ویرایش تصویر اصلی محصول با موفقیت انجام شد', 'باتشکر');
        return redirect()->back();
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'primary_image' => 'nullable|mimes:jpg,jpeg,png,svg',
            'images.*' => 'nullable|mimes:jpg,jpeg,png,svg',
        ]);

        if ($request->primary_image == null && $request->images == null) {
            return redirect()->back()->withErrors(['msg' => 'تصویر یا تصاویر محصول الزامی هست']);
        }

        try {
            DB::beginTransaction();

            if ($request->has('primary_image')) {

                $fileNamePrimaryImage = generateFileName($request->primary_image->getClientOriginalName());
                $request->primary_image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $fileNamePrimaryImage);

                $product->update([
                    'primary_image' => $fileNamePrimaryImage
                ]);
            }

            if ($request->has('images')) {

                foreach ($request->images as $image) {
                    $fileNameImage = generateFileName($image->getClientOriginalName());

                    $image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $fileNameImage);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $fileNameImage
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error('مشکل در ایجاد محصول', $ex->getMessage())->persistent('حله');
            return redirect()->back();
        }

        alert()->success('ویرایش تصویر اصلی محصول با موفقیت انجام شد', 'باتشکر');
        return redirect()->back();
    }
}
