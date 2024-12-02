<h2 class="h5 no-margin-bottom">Dashboard</h2>

<section class="no-padding-top no-padding-bottom">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-user-1"></i></div><strong>Users</strong>
                        </div>
                        <div class="number dashtext-1">{{$totalUsers}}</div>
                    </div>
                    <div class="progress progress-template">
                        <div role="progressbar" style="width: {{ ($totalUsers > 0) ? ($totalUsers / 100) * 100 : 0}}%" aria-valuenow="{{$totalUsers}}" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-1"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-contract"></i></div><strong>Orders</strong>
                        </div>
                        <div class="number dashtext-2">{{$totalOrders}}</div>
                    </div>
                    <div class="progress progress-template">
                        <div role="progressbar" style="width: {{ ($totalOrders > 0) ? ($totalOrders / 100) * 100 : 0}}%; transition: width 0.5s ease-in-out;" aria-valuenow="{{$totalOrders}}" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-2"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-paper-and-pencil"></i></div><strong>Delivered</strong>
                        </div>
                        <div class="number dashtext-3">{{$totalDelivered}}</div>
                    </div>
                    <div class="progress progress-template">
                        <div role="progressbar" style="width: {{ ($totalDelivered > 0) ? ($totalDelivered / 100) * 100 : 0}}%" aria-valuenow="{{$totalDelivered}}" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-3"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-writing-whiteboard"></i></div><strong>On The Way</strong>
                        </div>
                        <div class="number dashtext-4">{{$totalOnTheWay}}</div>
                    </div>
                    <div class="progress progress-template">
                        <div role="progressbar" style="width:{{ ($totalOnTheWay > 0) ? ($totalOnTheWay / 100) * 100 : 0}}%" aria-valuenow="{{$totalOnTheWay}}" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-4"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon"></i></div><strong>Stores</strong>
                        </div>
                        <div class="number dashtext-4">{{$totalStores}}</div>
                    </div>
                    <div class="progress progress-template">
                        <div role="progressbar" style="width:{{ ($totalStores > 0) ? ($totalStores / 100) * 100 : 0}}%" aria-valuenow="{{$totalOnTheWay}}" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</section>
<footer class="footer">
    <div class="footer__block block no-margin-bottom">
        <div class="container-fluid text-center">
            <p class="no-margin-bottom">2022 &copy; Ahmed Rady</p>
        </div>
    </div>
</footer>
