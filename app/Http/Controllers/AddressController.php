<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = auth()->user()->addresses;
        return view('user.addresses', compact('addresses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'landmark' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'is_default' => 'boolean'
        ]);

        $validated['user_id'] = auth()->id();

        if ($validated['is_default']) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        Address::create($validated);

        return redirect()->route('addresses.index')->with('success', 'Địa chỉ đã được thêm thành công.');
    }

    public function update(Request $request, Address $address)
    {
        $this->authorize('update', $address);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'landmark' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'is_default' => 'boolean'
        ]);

        if ($validated['is_default']) {
            auth()->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('addresses.index')->with('success', 'Địa chỉ đã được cập nhật thành công.');
    }

    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);
        
        $address->delete();

        return redirect()->route('addresses.index')->with('success', 'Địa chỉ đã được xóa thành công.');
    }
} 