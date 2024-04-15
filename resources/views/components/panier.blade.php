<!-- Panier -->
<div class="card">
    <div class="card-header text-center mb-0">
        <i class="bi bi-cart4"></i>
        <strong>Panier</strong>
    </div>
    <div class="card-body w-100 p-0 md-0 h-100">
        <table class="table table-lg mb-0 p-0">
            <thead>
                <tr>
                    <th>Iphone</th>
                    <th>Etat</th>
                    <th>Prix</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
