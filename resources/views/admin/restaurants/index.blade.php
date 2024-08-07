@extends('layouts.admin')

{{-- sezioni da condizionare in base alla presenza di user -> restaurant!!! --}}
@section('content')
@if (!$user_restaurant)
  <section>
    <div class="container">
    <h1 class="text-center gradientColor">Effettua la registrazione</h1>
    <form action="{{route('admin.restaurants.store')}}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
      <label for="name" class="form-label">Nome</label>
      <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
        placeholder="Inserisci il nome">
      </div>
      @error('name')
      <div class="alert alert-danger">{{ $message }}</div>
    @enderror
      <div class="mb-3">
      <label for="address" class="form-label">Indirizzo</label>
      <input type="text" class="form-control" id="address" name="address" placeholder="Inserisci l'indirizzo">
      </div>
      @error('address')
      <div class="alert alert-danger">{{ $message }}</div>
    @enderror
      <div class="mb-3">
      {{-- @if(!$user_restaurant)
      <img class="shadow" width="150" src="{{asset('images/placeholder.png')}}" alt="" id="uploadPreview">
      @else
      <img class="shadow" width="150" src="{{asset('storage/restaurant_images/' . $user_restaurant->image)}}"
        alt="{{$user_restaurant->name}}" id="uploadPreview">
      @endif --}}

      <label for="image" class="form-label">Immagine</label>
      <input type="file" accept="image/*" class="form-control @error('image') is-invalid @enderror" id="uploadImage"
        name="image" value="{{ old('image') }}" maxlength="5120">
      @error('image')
      <div class="alert alert-danger">{{ $message }}</div>
    @enderror
      </div>
      <div class="mb-3">
      <label for="description" class="form-label">Descrizione</label>
      <input type="text" class="form-control" id="description" name="description"
        placeholder="Inserisci la descrizione">
      </div>
      @error('description')
      <div class="alert alert-danger">{{ $message }}</div>
    @enderror
      <div class="mb-3">
      <label for="vat" class="form-label">Partita IVA</label>
      <input type="text" class="form-control" id="vat" name="vat" placeholder="Inserisci la Partita IVA">
      </div>
      @error('vat')
      <div class="alert alert-danger">{{ $message }}</div>
    @enderror
      <button type="submit" class="btn btn-success">Invia</button>
    </form>
    </div>
  </section>

@elseif ($user_products->isEmpty())
  <section>
    <div class="container d-flex flex-column justify-content-between align-items-center">
    <h1 class="text-center f-d-color-primary pt-4">Nessun piatto disponibile per: {{$user_restaurant->name}}</h1>
    <p class="text-center f-d-color-primary">Per favore, aggiungi il primo piatto.</p>



    <a href="{{ route('admin.products.create') }}" class="f-d-button-form-edit">Aggiungi piatto</a>
    </div>
  </section>

@else

  <h1 class="text-center f-d-color-primary mt-1 p-2 fw-bold"><i
    class="fa-solid fa-utensils f-d-color-primary p-4 fw-bold"></i>Il tuo Ristorante</h1>

  {{-- Due sezioni: a sx img, a dx info ristorante --}}
  <div class="f-d-flex-mq d-flex">
    <div class="f-d-main-first-container f-d-main-image">
    <img src="{{asset('storage/' . $user_restaurant->image)}}" alt="{{$user_restaurant->name}}">
    </div>
    <div class="f-d-main-second-container">
    <div class="f-d-layer-dashboard ">
      <h2 class="text-white fw-bold p-2"><em class="text-white">{{$user_restaurant->name }}</em></h2>
      <p class="text-white fs-4"><i class="fa-solid fa-location-dot p-2 text-white"></i>{{ $user_restaurant->address }}
      </p>
      <p class="text-white fs-4"><i class="fa-solid fa-envelope p-2 text-white"></i>{{ $user_restaurant->vat }}</p>
      <h3 class="fw-bold p-2 text-white">Tipologie:</h3>
      <div class="">
      @foreach ($user_types as $type)
      <img class="f-d-img-font" src="{{asset('storage/' . $type->image)}}" alt="{{$type->name}}">
    @endforeach
      </div>
    </div>
    </div>
  </div>

  <h1 class="text-center f-d-color-primary p-2 fw-bold">Piatti</h1>

  <table class="f-d-table">
    <thead>
    <tr>
      <th scope="col">Nome</th>
      <th scope="col">Visibilità</th>
      <th scope="col">Prezzo</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($user_products as $item)
    <tr>
      <td><a class="text-white text-decoration-none"
      href="{{route('admin.products.show', $item->id)}}">{{$item->name}}</a></td>
      @if ($item->visible == 0)
      <td class="text-center pe-3"><i class="fs-3 fa-regular fa-circle-xmark" style="color: #ff2600;"></i></td>
    @else ($product->visible == 1)
    <td class="text-center pe-3"><i class="fs-3 fa-regular fa-circle-check" style="color: #ffffff;"></i></i></td>
    @endif
      <td class="text-end">{{$item->price}} &euro;</td>
    </tr>
  @endforeach
    </tbody>
  </table>



  {{-- <div class="mb-3">
    <p class="lightbrown fw-bold">VISIBILITA'</p>
    <input type="radio" name="visible" value="1" id="visible-1"
    class="form-check-input bg-black @if ($item->visible == 1) checked @endif">
    <label for="visible-1" class="form-label lightbrown fw-bold">Sì</label>

    <input type="radio" name="visible" value="0" id="visible-0"
    class="form-check-input bg-black @if ($item->visible == 0) checked @endif">
    <label for="visible-0" class="form-label lightbrown fw-bold">No</label>
  </div> --}}

  {{-- <ul>
    @foreach ($user_products as $item)
    <li>{{$item->name}}</li>
    @endforeach
  </ul>
  <a href="{{route('admin.products.create')}}" title="Create" class="text-black px-2"><button
    class="f-d-button-view">Aggiungi prodotto</button></a> --}}
@endif

@endsection

@section('sidebarContent')
@include('partials.sidebar')
@endsection