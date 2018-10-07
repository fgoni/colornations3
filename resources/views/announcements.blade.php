@if (App\Announcements::all()->count() > 0)
    <div class="col-md-12 bgm-red text-center c-white p-5 announcements">
        <i class="fa fa-warning m-r-15"></i> {{ App\Announcements::all()->first()->description }} <i
                class="fa fa-warning m-l-15"></i>
    </div>
@endif