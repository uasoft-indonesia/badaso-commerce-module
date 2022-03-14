<?php

namespace Uasoft\Badaso\Module\Commerce\Controllers\PublicController;

use Exception;
use Illuminate\Http\Request;
use Uasoft\Badaso\Controllers\Controller;
use Uasoft\Badaso\Helpers\ApiResponse;
use Uasoft\Badaso\Helpers\Config;
use Uasoft\Badaso\Module\Commerce\Models\Product;

class ProductController extends Controller
{
    public function browse(Request $request)
    {
        try {
            $request->validate([
                'page' => 'sometimes|required|integer',
            ]);

            $products = Product::with(['productCategory', 'productDetails.discount', 'productDetails' => function ($query) {
                return $query->withSum(['orderDetails as sold' => function ($query) {
                    return $query->whereHas('order', function ($query) {
                        $query
                            ->whereIn('status', ['process', 'delivering', 'done'])
                            ->whereDate('created_at', '>=', now()->startOfMonth())
                            ->whereDate('created_at', '<=', now()->endOfMonth());
                    });
                }], 'quantity');
            }])
                ->withAvg('review', 'rating')
                ->withCount('review')
                ->latest()
                ->paginate(Config::get('homeProductLimit') ?? 30);

            $data['products'] = collect($products)->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function browseSimilar(Request $request)
    {
        try {
            $request->validate([
                'slug' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\ProductCategory,slug',
            ]);

            $products = Product::with(['productCategory', 'productDetails', 'productDetails' => function ($query) {
                return $query->withSum(['orderDetails as sold' => function ($query) {
                    return $query->whereHas('order', function ($query) {
                        $query
                            ->whereIn('status', ['process', 'delivering', 'done'])
                            ->whereDate('created_at', '>=', now()->startOfMonth())
                            ->whereDate('created_at', '<=', now()->endOfMonth());
                    });
                }], 'quantity');
            }])
                ->whereHas('productCategory', function ($query) use ($request) {
                    $query->where('slug', $request->slug);
                })
                ->withAvg('review', 'rating')
                ->withCount('review')
                ->inRandomOrder()
                ->limit(Config::get('similarProductLimit'))
                ->get();

            $data['products'] = $products->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function browseByCategorySlug(Request $request)
    {
        try {
            $request->validate([
                'slug' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\ProductCategory,slug',
                'page' => 'sometimes|required|integer',
                'min' => 'nullable|integer',
                'max' => 'nullable|integer',
                'rating' => 'nullable',
            ]);

            $products = Product::with(['productCategory', 'productDetails.discount', 'productDetails' => function ($query) {
                return $query->withSum(['orderDetails as sold' => function ($query) {
                    return $query->whereHas('order', function ($query) {
                        $query
                            ->whereIn('status', ['process', 'delivering', 'done'])
                            ->whereDate('created_at', '>=', now()->startOfMonth())
                            ->whereDate('created_at', '<=', now()->endOfMonth());
                    });
                }], 'quantity')
                    ->when(request('min'), function ($query) {
                        return $query->where('price', '>=', request('min'));
                    })->when(request('max'), function ($query) {
                        return $query->where('price', '<=', request('max'));
                    });
            }])
                ->whereHas('productCategory', function ($query) use ($request) {
                    $query->where('slug', $request->slug);
                })
                ->withAvg('review', 'rating')
                ->withCount('review')
                ->latest();

            // filter the $products with rating
            if ((int) $request->rating > 0) {
                $products = $products->paginate(Config::get('homeProductLimit') ?? 30);
                $products = collect($products)->toArray();
                $products['data'] = collect($products['data'])->filter(function ($product) {
                    $rating = (int) $product['review_avg_rating'];
                    dd($rating >= request('rating'));

                    return $rating >= request('rating');
                });
            } else {
                $products = $products->paginate(Config::get('homeProductLimit') ?? 30);
            }

            $data['products'] = collect($products)->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function browseBestSellingProduct()
    {
        try {
            $products = Product::with(['productCategory', 'productDetails.discount', 'productDetails' => function ($query) {
                return $query->withSum(['orderDetails as sold' => function ($query) {
                    return $query->whereHas('order', function ($query) {
                        $query
                            ->whereIn('status', ['process', 'delivering', 'done'])
                            ->whereDate('created_at', '>=', now()->startOfMonth())
                            ->whereDate('created_at', '<=', now()->endOfMonth());
                    });
                }], 'quantity');
            }])
                ->withAvg('review', 'rating')
                ->withCount('review')
                ->get()
                ->sortByDesc(function ($product) {
                    $sold = 0;
                    foreach ($product->productDetails as $key => $productDetail) {
                        $sold += $productDetail->sold;
                    }

                    return $sold;
                })->take(Config::get('bestSellingLimit') ?? 30);

            $data['products'] = $products->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function read(Request $request)
    {
        try {
            $request->validate([
                'slug' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Product',
            ]);

            $product = Product::with(['productCategory', 'productDetails.discount', 'productDetails' => function ($query) {
                return $query->withSum(['orderDetails as sold' => function ($query) {
                    return $query->whereHas('order', function ($query) {
                        $query
                            ->whereIn('status', ['process', 'delivering', 'done'])
                            ->whereDate('created_at', '>=', now()->startOfMonth())
                            ->whereDate('created_at', '<=', now()->endOfMonth());
                    });
                }], 'quantity');
            }])
                ->withAvg('review', 'rating')
                ->withCount('review')
                ->where('slug', $request->slug)
                ->first();

            $data['product'] = $product->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function readSimple(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:Uasoft\Badaso\Module\Commerce\Models\Product,id',
            ]);

            $product = Product::with(['productCategory', 'productDetails.discount'])
                ->where('id', $request->id)
                ->firstOrFail();

            $data['product'] = $product->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }

    public function search(Request $request)
    {
        try {
            $request->validate([
                'keyword' => 'required|string',
                'page' => 'sometimes|required|integer',
                'min' => 'nullable|integer',
                'max' => 'nullable|integer',
                'rating' => 'nullable|integer',
            ]);

            $products = Product::with(['productCategory', 'productDetails.discount', 'productDetails' => function ($query) {
                return $query->withSum(['orderDetails as sold' => function ($query) {
                    return $query->whereHas('order', function ($query) {
                        $query
                            ->whereIn('status', ['process', 'delivering', 'done'])
                            ->whereDate('created_at', '>=', now()->startOfMonth())
                            ->whereDate('created_at', '<=', now()->endOfMonth());
                    });
                }], 'quantity')
                    ->when(request('min'), function ($query) {
                        return $query->where('price', '>=', request('min'));
                    })->when(request('max'), function ($query) {
                        return $query->where('price', '<=', request('max'));
                    });
            }])
                ->withAvg('review', 'rating')
                ->where('name', 'like', '%'.$request->keyword.'%')
                ->withCount('review')
                ->latest();

            if ((int) $request->rating > 0) {
                $products = $products->paginate(Config::get('homeProductLimit') ?? 30);
                $products = collect($products)->toArray();
                $products['data'] = collect($products['data'])->filter(function ($product) {
                    $rating = (int) $product['review_avg_rating'];

                    return $rating >= request('rating');
                });
            } else {
                $products = $products->paginate(Config::get('homeProductLimit') ?? 30);
            }

            $data['products'] = collect($products)->toArray();

            return ApiResponse::success($data);
        } catch (Exception $e) {
            return ApiResponse::failed($e);
        }
    }
}
