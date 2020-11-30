<div class="form-group row">
  <label for="title" class="col-md-3 col-form-label text-md-right">Problema</label>

  <div class="col-md-6">
    <input
      id="title"
      type="text"
      class="form-control @error('title') is-invalid @enderror"
      name="title"
      value="{{ old('title') ?? $problem->title ?? '' }}"
      required
      minlength="3"
      maxlength="50"
      autocomplete="off"
      autofocus>

    @error('title')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
    @enderror
  </div>
</div>

<div class="form-group row">
  <label for="desc" class="col-md-3 col-form-label text-md-right">Platus aprašymas</label>

  <div class="col-md-6">
    <textarea
      id="desc"
      type="text"
      class="form-control @error('desc') is-invalid @enderror"
      name="desc"
      required
      minlength="10"
      maxlength="1500"
      autocomplete="off">{{
      old('desc') ?? $problem->desc ?? ''
    }}</textarea>

    @error('desc')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
    @enderror
  </div>
</div>

