<div id="medicine-container">

    {{-- EDIT MODE --}}
    @if(isset($doctorNote) && $doctorNote->items->count())

        @foreach($doctorNote->items as $item)

            <div class="medicine-row row mb-2">

                {{-- PRODUCT SEARCH --}}
                <div class="col-md-4 position-relative">

                    <input type="text"
                           class="form-control product-input"
                           placeholder="Search Medicine"
                           autocomplete="off"
                           value="{{ $item->product->name ?? '' }}">

                    <input type="hidden"
                           name="product_id[]"
                           class="product-id"
                           value="{{ $item->product_id }}">

                    <div class="list-group product-suggestions"
                         style="
                            position:absolute;
                            z-index:9999;
                            width:100%;
                            display:none;
                         ">
                    </div>

                </div>

                {{-- DOSAGE --}}
                <div class="col-md-2">

                    <select name="dosage_id[]"
                            class="form-control">

                        <option value="">Dosage</option>

                        @foreach($dosages as $dosage)

                            <option value="{{ $dosage->id }}"
                                {{ $item->dosage_id == $dosage->id ? 'selected' : '' }}>

                                {{ $dosage->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- DURATION --}}
                <div class="col-md-2">

                    <input type="text"
                           name="duration[]"
                           class="form-control"
                           value="{{ $item->duration }}"
                           placeholder="Duration">

                </div>

                {{-- REMARKS --}}
                <div class="col-md-3">

                    <input type="text"
                           name="remarks[]"
                           class="form-control"
                           value="{{ $item->remarks }}"
                           placeholder="Remarks">

                </div>

                {{-- REMOVE --}}
                <div class="col-md-1">

                    <button type="button"
                            class="btn btn-danger remove-row">
                        X
                    </button>

                </div>

            </div>

        @endforeach

    @else

        {{-- CREATE MODE --}}
        <div class="medicine-row row mb-2">

            {{-- PRODUCT SEARCH --}}
            <div class="col-md-4 position-relative">

                <input type="text"
                       class="form-control product-input"
                       placeholder="Search Medicine"
                       autocomplete="off">

                <input type="hidden"
                       name="product_id[]"
                       class="product-id">

                <div class="list-group product-suggestions"
                     style="
                        position:absolute;
                        z-index:9999;
                        width:100%;
                        display:none;
                     ">
                </div>

            </div>

            {{-- DOSAGE --}}
            <div class="col-md-2">

                <select name="dosage_id[]"
                        class="form-control">

                    <option value="">Dosage</option>

                    @foreach($dosages as $dosage)

                        <option value="{{ $dosage->id }}">
                            {{ $dosage->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            {{-- DURATION --}}
            <div class="col-md-2">

                <input type="text"
                       name="duration[]"
                       class="form-control"
                       placeholder="Duration">

            </div>

            {{-- REMARKS --}}
            <div class="col-md-3">

                <input type="text"
                       name="remarks[]"
                       class="form-control"
                       placeholder="Remarks">

            </div>

            {{-- REMOVE --}}
            <div class="col-md-1">

                <button type="button"
                        class="btn btn-danger remove-row">
                    X
                </button>

            </div>

        </div>

    @endif

</div>


{{-- ADD BUTTON --}}
<div class="mt-2">

    <button type="button"
            onclick="addMedicineRow()"
            class="btn btn-primary btn-sm">

        Add Medicine

    </button>

</div>


{{-- TEMPLATE --}}
<div id="medicine-template" style="display:none;">

    <div class="medicine-row row mb-2">

        {{-- PRODUCT --}}
        <div class="col-md-4 position-relative">

            <input type="text"
                   class="form-control product-input"
                   placeholder="Search Medicine"
                   autocomplete="off">

            <input type="hidden"
                   name="product_id[]"
                   class="product-id">

            <div class="list-group product-suggestions"
                 style="
                    position:absolute;
                    z-index:9999;
                    width:100%;
                    display:none;
                 ">
            </div>

        </div>

        {{-- DOSAGE --}}
        <div class="col-md-2">

            <select name="dosage_id[]"
                    class="form-control">

                <option value="">Dosage</option>

                @foreach($dosages as $dosage)

                    <option value="{{ $dosage->id }}">
                        {{ $dosage->name }}
                    </option>

                @endforeach

            </select>

        </div>

        {{-- DURATION --}}
        <div class="col-md-2">

            <input type="text"
                   name="duration[]"
                   class="form-control"
                   placeholder="Duration">

        </div>

        {{-- REMARKS --}}
        <div class="col-md-3">

            <input type="text"
                   name="remarks[]"
                   class="form-control"
                   placeholder="Remarks">

        </div>

        {{-- REMOVE --}}
        <div class="col-md-1">

            <button type="button"
                    class="btn btn-danger remove-row">
                X
            </button>

        </div>

    </div>

</div>