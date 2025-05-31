@extends('dashboard.layouts.app')

@section('title', 'Logs des Commandes et Visiteurs')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Filtres</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('dashboard.logs') }}" class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Date début</label>
                                <input type="date" name="date_start" class="form-control" value="{{ request('date_start') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Date fin</label>
                                <input type="date" name="date_end" class="form-control" value="{{ request('date_end') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Source</label>
                                <input type="text" name="source" class="form-control" value="{{ request('source') }}" placeholder="Source de trafic">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Statut commande</label>
                                <select name="status" class="form-control">
                                    <option value="">Tous</option>
                                    <option value="encours" {{ request('status') == 'encours' ? 'selected' : '' }}>En cours</option>
                                    <option value="traite" {{ request('status') == 'traite' ? 'selected' : '' }}>Traité</option>
                                    <option value="annule" {{ request('status') == 'annule' ? 'selected' : '' }}>Annulé</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary">Filtrer</button>
                            <a href="{{ route('dashboard.logs') }}" class="btn btn-secondary">Réinitialiser</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#visitors" role="tab">Visiteurs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#orders" role="tab">Commandes</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="visitors" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date/Heure</th>
                                            <th>IP</th>
                                            <th>Pays</th>
                                            <th>Ville</th>
                                            <th>OS</th>
                                            <th>Navigateur</th>
                                            <th>Appareil</th>
                                            <th>Source</th>
                                            <th>Page visitée</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($visitors as $visitor)
                                            <tr>
                                                <td>{{ $visitor->visit_time->format('d/m/Y H:i:s') }}</td>
                                                <td>{{ $visitor->ip_address }}</td>
                                                <td>{{ $visitor->country ?? 'N/A' }}</td>
                                                <td>{{ $visitor->city ?? 'N/A' }}</td>
                                                <td>{{ $visitor->os ?? 'N/A' }}</td>
                                                <td>{{ $visitor->browser ?? 'N/A' }}</td>
                                                <td>{{ $visitor->device ?? 'N/A' }}</td>
                                                <td>{{ $visitor->referer ?? 'Direct' }}</td>
                                                <td>{{ $visitor->visited_page }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">Aucun visiteur trouvé</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $visitors->links() }}
                        </div>

                        <div class="tab-pane" id="orders" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date/Heure</th>
                                            <th>Référence</th>
                                            <th>Client</th>
                                            <th>Email</th>
                                            <th>Téléphone</th>
                                            <th>Montant</th>
                                            <th>Statut</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($orders as $order)
                                            <tr>
                                                <td>{{ $order->date_order->format('d/m/Y H:i:s') }}</td>
                                                <td>{{ $order->red_order }}</td>
                                                <td>{{ $order->prenom }} {{ $order->nom }}</td>
                                                <td>{{ $order->email }}</td>
                                                <td>{{ $order->telephone }}</td>
                                                <td>{{ number_format($order->prix_produit * $order->quantite_produit, 3) }} TND</td>
                                                <td>
                                                    <span class="badge badge-{{ $order->status == 'traite' ? 'success' : ($order->status == 'annule' ? 'danger' : 'warning') }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('dashboard.commandes.show', $order->red_order) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Aucune commande trouvée</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush
