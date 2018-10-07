<!-- Javascript Libraries -->
<script src="{{ asset('/js/jquery-2.1.1.min.js', Request::secure()) }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.pjax/1.9.6/jquery.pjax.min.js"></script>
<script src="{{ asset('/js/bootstrap.min.js', Request::secure()) }}"></script>

<script src="{{ asset('/vendors/auto-size/jquery.autosize.min.js', Request::secure()) }}"></script>
<script src="{{ asset('/vendors/nicescroll/jquery.nicescroll.min.js', Request::secure()) }}"></script>
<script src="{{ asset('/vendors/waves/waves.min.js', Request::secure()) }}"></script>
<script src="{{ asset('/vendors/bootstrap-growl/bootstrap-growl.min.js', Request::secure()) }}"></script>
<script src="{{ asset('/vendors/sweet-alert/sweet-alert.min.js', Request::secure()) }}"></script>
<script src="{{ asset('js/vue.js', Request::secure()) }}"></script>

<script src="{{ asset('/js/functions.js', Request::secure()) }}"></script>
<script src="{{ asset('js/app.js', Request::secure()) }}"></script>
<script>
    $('#logout').on('click', function (e) {
        e.preventDefault();
        swal({
            title: "Are you sure you want to log out?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: false
        }, function () {
            location.href = '{{ url('auth/logout') }}';
        })
    });
</script>

<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-69497659-4', 'auto');
    ga('send', 'pageview');

</script>

<script>
    $(document).pjax('a', '#pjax-container')
</script>
<script>
    $(document).on('pjax:end', function () {
        $('a').each(function () {
            if (window.location == $(this).attr('href')) {
                $(this).closest('li').addClass('active');
            }
            else if (window.location == $(this).attr('href') + '/') {
                $(this).closest('li').addClass('active');
            }
            else {
                $(this).closest('li').removeClass('active');
            }
        });
    })
</script>