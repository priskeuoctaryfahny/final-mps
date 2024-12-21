<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot
    <h2 class="mb-4">{{ $title }} {{ $type == 'in' ? 'Masuk' : 'Keluar' }}</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST"
                action="{{ route('transactions.store') }}" onsubmit="showLoader()">
                @csrf

                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="gas_id" value="{{ $id }}">

                <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input class="form-control" id="qty" type="number" name="qty" placeholder="Jumlah"
                            value="{{ old('qty') }}" required />
                        <label for="qty">Jumlah (Qty/Unit)</label>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input class="form-control" id="amount" type="number" step="0.01" name="amount"
                            placeholder="Jumlah Uang" value="{{ old('amount') }}" required />
                        <label for="amount">Jumlah Uang</label>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input class="form-control" id="optional_amount" type="number" step="0.01"
                            name="optional_amount" placeholder="Jumlah Opsional"
                            value="{{ old('optional_amount', 0) }}" />
                        <label for="optional_amount">Jumlah Uang Tambahan (Opsional)</label>
                    </div>
                </div>





                <div class="col-sm-6 col-md-6">
                    <div class="form-floating">
                        <input class="form-control" id="transaction_date" type="date" name="transaction_date"
                            value="{{ old('transaction_date') }}" />
                        <label for="transaction_date">Tanggal Transaksi</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating form-floating-advance-select">
                        <label>Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                                Selesai
                            </option>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>
                                Proses
                            </option>
                            <option value="canceled" {{ old('status') == 'canceled' ? 'selected' : '' }}>
                                Dibatalkan
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="reference" type="text" name="reference"
                            placeholder="Referensi" value="{{ old('reference') }}" />
                        <label for="reference">Referensi</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-12">
                    <label for="attachment">Lampiran</label>
                    <input class="form-control" id="attachment" type="file" name="attachment" />
                </div>



                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <textarea class="form-control" id="description" name="description" placeholder="Keterangan" style="height: 200px">{{ old('description') }}</textarea>
                        <label for="description">Keterangan</label>
                    </div>
                </div>

                <div class="col-12 gy-6">
                    <div class="row g-3 justify-content-end">
                        <div class="col-auto">
                            <a href="{{ route('transactions.index', $id) }}" class="btn btn-phoenix-primary px-5"
                                type="button">Batal</a>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary px-5 px-sm-15">Tambah</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-dash.layout>
