@extends('backend.layout.master')
@section('title', 'Edit School')
@section('content')

<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Edit School</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('schools.update', ['id' => $school->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">School Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $school->name }}">
                </div>

                <div class="form-group">
                    <label for="level">Level</label>
                    <select name="level" class="form-control">
                        <option value="National" {{ $school->level == 'National' ? 'selected' : '' }}>National</option>
                        <option value="Extra-County" {{ $school->level == 'Extra-County' ? 'selected' : '' }}>Extra-County</option>
                        <option value="County" {{ $school->level == 'County' ? 'selected' : '' }}>County</option>
                        <option value="Sub-County" {{ $school->level == 'Sub-County' ? 'selected' : '' }}>Sub-County</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" class="form-control">
                        <option value="Boys" {{ $school->type == 'Boys' ? 'selected' : '' }}>Boys</option>
                        <option value="Girls" {{ $school->type == 'Girls' ? 'selected' : '' }}>Girls</option>
                        <option value="Mixed" {{ $school->type == 'Mixed' ? 'selected' : '' }}>Mixed</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="county">County</label>
                    <select name="county" class="form-control">
                        <option value="">Select County</option>
                        <option value="Baringo" {{ $school->county == 'Baringo' ? 'selected' : '' }}>Baringo</option>
                        <option value="Bomet" {{ $school->county == 'Bomet' ? 'selected' : '' }}>Bomet</option>
                        <option value="Bungoma" {{ $school->county == 'Bungoma' ? 'selected' : '' }}>Bungoma</option>
                        <option value="Busia" {{ $school->county == 'Busia' ? 'selected' : '' }}>Busia</option>
                        <option value="Elgeyo-Marakwet" {{ $school->county == 'Elgeyo-Marakwet' ? 'selected' : '' }}>Elgeyo-Marakwet</option>
                        <option value="Embu" {{ $school->county == 'Embu' ? 'selected' : '' }}>Embu</option>
                        <option value="Garissa" {{ $school->county == 'Garissa' ? 'selected' : '' }}>Garissa</option>
                        <option value="Homa Bay" {{ $school->county == 'Homa Bay' ? 'selected' : '' }}>Homa Bay</option>
                        <option value="Isiolo" {{ $school->county == 'Isiolo' ? 'selected' : '' }}>Isiolo</option>
                        <option value="Kajiado" {{ $school->county == 'Kajiado' ? 'selected' : '' }}>Kajiado</option>
                        <option value="Kakamega" {{ $school->county == 'Kakamega' ? 'selected' : '' }}>Kakamega</option>
                        <option value="Kericho" {{ $school->county == 'Kericho' ? 'selected' : '' }}>Kericho</option>
                        <option value="Kiambu" {{ $school->county == 'Kiambu' ? 'selected' : '' }}>Kiambu</option>
                        <option value="Kilifi" {{ $school->county == 'Kilifi' ? 'selected' : '' }}>Kilifi</option>
                        <option value="Kirinyaga" {{ $school->county == 'Kirinyaga' ? 'selected' : '' }}>Kirinyaga</option>
                        <option value="Kisii" {{ $school->county == 'Kisii' ? 'selected' : '' }}>Kisii</option>
                        <option value="Kisumu" {{ $school->county == 'Kisumu' ? 'selected' : '' }}>Kisumu</option>
                        <option value="Kitui" {{ $school->county == 'Kitui' ? 'selected' : '' }}>Kitui</option>
                        <option value="Kwale" {{ $school->county == 'Kwale' ? 'selected' : '' }}>Kwale</option>
                        <option value="Laikipia" {{ $school->county == 'Laikipia' ? 'selected' : '' }}>Laikipia</option>
                        <option value="Lamu" {{ $school->county == 'Lamu' ? 'selected' : '' }}>Lamu</option>
                        <option value="Machakos" {{ $school->county == 'Machakos' ? 'selected' : '' }}>Machakos</option>
                        <option value="Makueni" {{ $school->county == 'Makueni' ? 'selected' : '' }}>Makueni</option>
                        <option value="Mandera" {{ $school->county == 'Mandera' ? 'selected' : '' }}>Mandera</option>
                        <option value="Marsabit" {{ $school->county == 'Marsabit' ? 'selected' : '' }}>Marsabit</option>
                        <option value="Meru" {{ $school->county == 'Meru' ? 'selected' : '' }}>Meru</option>
                        <option value="Migori" {{ $school->county == 'Migori' ? 'selected' : '' }}>Migori</option>
                        <option value="Mombasa" {{ $school->county == 'Mombasa' ? 'selected' : '' }}>Mombasa</option>
                        <option value="Murang'a" {{ $school->county == "Murang'a" ? 'selected' : '' }}>Murang'a</option>
                        <option value="Nairobi" {{ $school->county == 'Nairobi' ? 'selected' : '' }}>Nairobi</option>
                        <option value="Nakuru" {{ $school->county == 'Nakuru' ? 'selected' : '' }}>Nakuru</option>
                        <option value="Nandi" {{ $school->county == 'Nandi' ? 'selected' : '' }}>Nandi</option>
                        <option value="Narok" {{ $school->county == 'Narok' ? 'selected' : '' }}>Narok</option>
                        <option value="Nyamira" {{ $school->county == 'Nyamira' ? 'selected' : '' }}>Nyamira</option>
                        <option value="Nyandarua" {{ $school->county == 'Nyandarua' ? 'selected' : '' }}>Nyandarua</option>
                        <option value="Nyeri" {{ $school->county == 'Nyeri' ? 'selected' : '' }}>Nyeri</option>
                        <option value="Samburu" {{ $school->county == 'Samburu' ? 'selected' : '' }}>Samburu</option>
                        <option value="Siaya" {{ $school->county == 'Siaya' ? 'selected' : '' }}>Siaya</option>
                        <option value="Taita-Taveta" {{ $school->county == 'Taita-Taveta' ? 'selected' : '' }}>Taita-Taveta</option>
                        <option value="Tana River" {{ $school->county == 'Tana River' ? 'selected' : '' }}>Tana River</option>
                        <option value="Tharaka-Nithi" {{ $school->county == 'Tharaka-Nithi' ? 'selected' : '' }}>Tharaka-Nithi</option>
                        <option value="Trans Nzoia" {{ $school->county == 'Trans Nzoia' ? 'selected' : '' }}>Trans Nzoia</option>
                        <option value="Turkana" {{ $school->county == 'Turkana' ? 'selected' : '' }}>Turkana</option>
                        <option value="Uasin Gishu" {{ $school->county == 'Uasin Gishu' ? 'selected' : '' }}>Uasin Gishu</option>
                        <option value="Vihiga" {{ $school->county == 'Vihiga' ? 'selected' : '' }}>Vihiga</option>
                        <option value="Wajir" {{ $school->county == 'Wajir' ? 'selected' : '' }}>Wajir</option>
                        <option value="West Pokot" {{ $school->county == 'West Pokot' ? 'selected' : '' }}>West Pokot</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $school->status == 1 ? 'selected' : '' }}>Publish</option>
                        <option value="0" {{ $school->status == 0 ? 'selected' : '' }}>Unpublish</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-sm btn-primary">Update School</button>
            </form>
        </div>
    </div>
</div>

@endsection
