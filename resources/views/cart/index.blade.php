@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Banner -->
    <div class="bg-white p-4 rounded-4 shadow-sm border mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
        <div>
            <h3 class="fw-bold mb-1 text-dark">
                <i class="fa-solid fa-cart-shopping text-primary me-2"></i>Session-Based Shopping Cart & 3-Step Checkout Wizard
            </h3>
            <p class="text-muted mb-0 small">Pure Laravel Session-driven cart state, multi-stage checkout wizard & JSON backup/restore studio</p>
        </div>
        <div class="d-flex gap-2 mt-3 mt-md-0">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-house me-1"></i> Dashboard
            </a>
            <a href="{{ route('session_inspector.index') }}" class="btn btn-outline-info btn-sm">
                <i class="fa-solid fa-user-shield me-1"></i> Session Inspector
            </a>
            <a href="{{ route('cart.backup') }}" class="btn btn-success btn-sm fw-bold">
                <i class="fa-solid fa-file-export me-1"></i> Backup Cart (JSON)
            </a>
            <button type="button" class="btn btn-outline-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#restoreModal">
                <i class="fa-solid fa-file-import me-1"></i> Restore Backup
            </button>
        </div>
    </div>

    <!-- Product Catalog & Cart Summary Row -->
    <div class="row g-4 mb-4">
        <!-- Products Catalog -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-1"><i class="fa-solid fa-store text-primary me-2"></i>Product Catalog</h5>
                    <p class="text-muted small mb-0">Select items to insert directly into Laravel <code>session('cart')</code></p>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @foreach($products as $prod)
                            <div class="col-md-6">
                                <div class="card border shadow-sm h-100 rounded-3 p-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3">
                                            <i class="fa-solid {{ $prod['icon'] }} fa-xl"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0 text-dark">{{ $prod['name'] }}</h6>
                                            <span class="badge bg-light text-muted border mt-1">{{ $prod['category'] }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                        <div class="fw-bold text-success fs-5">${{ number_format($prod['price'], 2) }}</div>
                                        <form action="{{ route('cart.add') }}" method="POST" class="d-flex gap-2">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $prod['id'] }}">
                                            <input type="number" name="quantity" value="1" min="1" max="10" class="form-control form-control-sm text-center" style="width: 60px;">
                                            <button type="submit" class="btn btn-primary btn-sm fw-bold">
                                                <i class="fa-solid fa-plus me-1"></i> Add
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Session Shopping Cart Table -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1"><i class="fa-solid fa-basket-shopping text-success me-2"></i>Active Session Cart</h5>
                        <p class="text-muted small mb-0">{{ count($cart) }} unique item(s) in session</p>
                    </div>
                    @if(!empty($cart))
                        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Clear entire session cart?');">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="fa-solid fa-trash-can me-1"></i> Clear Cart
                            </button>
                        </form>
                    @endif
                </div>
                <div class="card-body p-4">
                    @if(empty($cart))
                        <div class="text-center py-5">
                            <i class="fa-solid fa-cart-arrow-down fa-3x text-muted mb-3 opacity-50"></i>
                            <h6 class="fw-bold text-muted">Your Session Cart is Empty</h6>
                            <p class="text-muted extra-small">Add items from the product catalog to begin state tracking.</p>
                        </div>
                    @else
                        <div class="table-responsive mb-3">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item</th>
                                        <th class="text-center" style="width: 110px;">Qty</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-end"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $id => $item)
                                        <tr>
                                            <td>
                                                <div class="fw-bold text-dark small">{{ $item['name'] }}</div>
                                                <small class="text-muted">${{ number_format($item['price'], 2) }}</small>
                                            </td>
                                            <td>
                                                <form action="{{ route('cart.update') }}" method="POST" class="d-flex align-items-center justify-content-center">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="99" onchange="this.form.submit()" class="form-control form-control-sm text-center px-1">
                                                </form>
                                            </td>
                                            <td class="text-end fw-bold text-dark small">
                                                ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                            </td>
                                            <td class="text-end">
                                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-link text-danger p-0 border-0" title="Remove item">
                                                        <i class="fa-solid fa-circle-xmark"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Billing Summary -->
                        <div class="bg-light p-3 rounded-3 border mb-3">
                            <div class="d-flex justify-content-between small text-muted mb-1">
                                <span>Subtotal:</span>
                                <strong>${{ number_format($subtotal, 2) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between small text-muted mb-2">
                                <span>Estimated Tax (8%):</span>
                                <strong>${{ number_format($tax, 2) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-2 fw-bold text-dark fs-5">
                                <span>Grand Total:</span>
                                <span class="text-primary">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 3-Step Checkout Session Wizard -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-1"><i class="fa-solid fa-wand-magic-sparkles text-warning me-2"></i>3-Step Multi-Stage Checkout Wizard</h5>
                    <p class="text-muted small mb-0">Multi-page checkout state preserved dynamically inside <code>session('checkout')</code></p>
                </div>
                <div class="card-body p-4">
                    @php
                        $currentStep = $checkoutData['current_step'] ?? 1;
                        $step1Data = $checkoutData['step1'] ?? [];
                        $step2Data = $checkoutData['step2'] ?? [];
                    @endphp

                    <!-- Wizard Progress Tracker -->
                    <div class="row text-center mb-4 g-2">
                        <div class="col-4">
                            <div class="p-3 rounded-3 border {{ $currentStep >= 1 ? 'bg-primary text-white border-primary' : 'bg-light text-muted' }}">
                                <div class="fw-bold"><i class="fa-solid fa-1 me-1"></i> Customer Details</div>
                                <small class="extra-small d-none d-md-block">{{ !empty($step1Data) ? '✔ Saved in Session' : 'Step 1' }}</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 rounded-3 border {{ $currentStep >= 2 ? 'bg-primary text-white border-primary' : 'bg-light text-muted' }}">
                                <div class="fw-bold"><i class="fa-solid fa-2 me-1"></i> Shipping Address</div>
                                <small class="extra-small d-none d-md-block">{{ !empty($step2Data) ? '✔ Saved in Session' : 'Step 2' }}</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 rounded-3 border {{ $currentStep === 3 ? 'bg-success text-white border-success' : 'bg-light text-muted' }}">
                                <div class="fw-bold"><i class="fa-solid fa-3 me-1"></i> Confirm & Place</div>
                                <small class="extra-small d-none d-md-block">Final Review</small>
                            </div>
                        </div>
                    </div>

                    <!-- Step 1 Form: Customer Info -->
                    @if($currentStep === 1)
                        <form action="{{ route('cart.wizard') }}" method="POST">
                            @csrf
                            <input type="hidden" name="step" value="1">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small text-dark">Full Name</label>
                                    <input type="text" name="customer_name" value="{{ $step1Data['name'] ?? '' }}" class="form-control" required placeholder="John Doe">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small text-dark">Email Address</label>
                                    <input type="email" name="customer_email" value="{{ $step1Data['email'] ?? '' }}" class="form-control" required placeholder="john@example.com">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small text-dark">Phone Number</label>
                                    <input type="text" name="customer_phone" value="{{ $step1Data['phone'] ?? '' }}" class="form-control" required placeholder="+1 555-0199">
                                </div>
                            </div>
                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-primary fw-bold">
                                    Save & Proceed to Step 2 <i class="fa-solid fa-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </form>

                    <!-- Step 2 Form: Shipping Address -->
                    @elseif($currentStep === 2)
                        <form action="{{ route('cart.wizard') }}" method="POST">
                            @csrf
                            <input type="hidden" name="step" value="2">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Street Address</label>
                                    <input type="text" name="shipping_address" value="{{ $step2Data['address'] ?? '' }}" class="form-control" required placeholder="123 Innovation Way">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold small text-dark">City</label>
                                    <input type="text" name="shipping_city" value="{{ $step2Data['city'] ?? '' }}" class="form-control" required placeholder="New York">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold small text-dark">Zip / Postal Code</label>
                                    <input type="text" name="shipping_zip" value="{{ $step2Data['zip'] ?? '' }}" class="form-control" required placeholder="10001">
                                </div>
                            </div>
                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-primary fw-bold">
                                    Save & Proceed to Final Step <i class="fa-solid fa-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </form>

                    <!-- Step 3: Order Review & Confirmation -->
                    @elseif($currentStep === 3)
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-3 border">
                                    <h6 class="fw-bold text-dark"><i class="fa-solid fa-user me-2"></i>Customer Information</h6>
                                    <p class="small mb-1"><strong>Name:</strong> {{ $step1Data['name'] ?? 'N/A' }}</p>
                                    <p class="small mb-1"><strong>Email:</strong> {{ $step1Data['email'] ?? 'N/A' }}</p>
                                    <p class="small mb-0"><strong>Phone:</strong> {{ $step1Data['phone'] ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-3 border">
                                    <h6 class="fw-bold text-dark"><i class="fa-solid fa-location-dot me-2"></i>Shipping Address</h6>
                                    <p class="small mb-1"><strong>Address:</strong> {{ $step2Data['address'] ?? 'N/A' }}</p>
                                    <p class="small mb-1"><strong>City:</strong> {{ $step2Data['city'] ?? 'N/A' }}</p>
                                    <p class="small mb-0"><strong>Zip:</strong> {{ $step2Data['zip'] ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 border-top pt-3 text-end">
                            <form action="{{ route('cart.wizard') }}" method="POST">
                                @csrf
                                <input type="hidden" name="step" value="3">
                                <button type="submit" class="btn btn-success btn-lg fw-bold px-4" {{ empty($cart) ? 'disabled' : '' }}>
                                    <i class="fa-solid fa-check-circle me-1"></i> Complete Order (${{ number_format($total, 2) }})
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Restore Backup JSON Modal -->
<div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('cart.restore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="restoreModalLabel"><i class="fa-solid fa-file-import text-primary me-2"></i>Restore Cart Session JSON</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small">Upload a previously exported <code>.json</code> cart backup to restore items directly into your active session.</p>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">JSON Backup File</label>
                        <input type="file" name="backup_file" accept=".json" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary fw-bold"><i class="fa-solid fa-upload me-1"></i> Restore Session Cart</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
