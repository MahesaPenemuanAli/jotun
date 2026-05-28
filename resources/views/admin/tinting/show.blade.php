<x-layouts.admin :title="'Detail Request Tinting'">

    <div style="margin-bottom:16px">
        <a href="{{ route('admin.tinting.index') }}" class="admin-btn admin-btn-outline admin-btn-sm">← Kembali ke Daftar</a>
    </div>

    <div style="display:grid;grid-template-columns:1.2fr 0.8fr;gap:20px;align-items:start">
        {{-- Request Info --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h2>Informasi Request</h2>
                <span class="badge badge-{{ $tintingRequest->status }}">{{ ucfirst($tintingRequest->status) }}</span>
            </div>
            <div class="admin-card-body">
                <dl class="detail-grid">
                    <dt>ID Request</dt>
                    <dd><code style="font-size:0.82rem">{{ $tintingRequest->id_request }}</code></dd>

                    <dt>Tanggal</dt>
                    <dd>{{ $tintingRequest->tanggal_request->format('d F Y') }}</dd>

                    <dt>Pelanggan</dt>
                    <dd><strong>{{ $tintingRequest->pelanggan->nama_pelanggan ?? '-' }}</strong></dd>

                    <dt>No. HP</dt>
                    <dd>{{ $tintingRequest->pelanggan->no_hp ?? '-' }}</dd>

                    <dt>Email</dt>
                    <dd>{{ $tintingRequest->pelanggan->email ?? '-' }}</dd>

                    <dt>Ditangani oleh</dt>
                    <dd>{{ $tintingRequest->admin->nama_admin ?? 'Belum ditangani' }}</dd>
                </dl>

                {{-- Detail Items --}}
                <h3 style="margin:24px 0 12px;color:var(--admin-navy)">Detail Warna & Kaleng</h3>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Warna</th>
                                <th>Produk</th>
                                <th>Kode</th>
                                <th>Kaleng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tintingRequest->detail as $detail)
                                <tr>
                                    <td>
                                        <div class="color-preview-box">
                                            <span class="color-swatch" style="background:{{ $detail->warna->hex_color ?? '#ccc' }}"></span>
                                            <strong>{{ $detail->warna->nama_warna ?? '-' }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $detail->warna->produk->nama_produk ?? '-' }}</td>
                                    <td>{{ $detail->warna->kode_warna ?? '-' }}</td>
                                    <td><strong>{{ $detail->jumlah_kaleng }}</strong> kaleng</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Status Update --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h2>Ubah Status</h2>
            </div>
            <div class="admin-card-body">
                <p style="color:var(--admin-muted);font-size:0.9rem;margin:0 0 16px">
                    Status saat ini: <span class="badge badge-{{ $tintingRequest->status }}">{{ ucfirst($tintingRequest->status) }}</span>
                </p>

                <div style="display:grid;gap:8px">
                    @php
                        $statuses = [
                            'pending' => ['label' => 'Pending', 'class' => 'admin-btn-outline', 'icon' => '⏳'],
                            'diproses' => ['label' => 'Diproses', 'class' => 'admin-btn-primary', 'icon' => '🔄'],
                            'selesai' => ['label' => 'Selesai', 'class' => 'admin-btn-success', 'icon' => '✅'],
                            'dibatalkan' => ['label' => 'Dibatalkan', 'class' => 'admin-btn-danger', 'icon' => '❌'],
                        ];
                    @endphp

                    @foreach ($statuses as $key => $info)
                        @if ($key !== $tintingRequest->status)
                            <form method="POST" action="{{ route('admin.tinting.updateStatus', $tintingRequest->id_request) }}"
                                  onsubmit="return confirm('Ubah status menjadi {{ $info['label'] }}?')">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="{{ $key }}">
                                <button type="submit" class="admin-btn {{ $info['class'] }}" style="width:100%">
                                    {{ $info['icon'] }} Ubah ke {{ $info['label'] }}
                                </button>
                            </form>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</x-layouts.admin>
