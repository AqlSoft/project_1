<div class="container pt-5" style="min-height: 100vh">

    <div class="card w-100 px-3">
        <div class="card-header">
            <h4> جمــــــيع العقـــــود </h4>
        </div>

        <table class="w-100 my-5">

            <thead>

                <tr>
                    <th>#</th>
                    <th>اسم العميل</th>
                    <th>نوع العميل</th>
                    <th>العقود</th>
                    <th><i class="fa fa-cogs"></i></th>
                </tr>
            </thead>
            <tbody>

                @foreach ($clients as $c => $client)
                    @if (!empty($clients))
                        <tr>
                            <td>{{ isset($_GET['page']) ? ++$c + ($_GET['page'] - 1) * 10 : ++$c }}</td>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->the_type }}</td>
                            <td>
                                @if (0 == count($client->contracts))
                                    <table class="w-100 subtable">

                                        <tr>
                                            <th>
                                                لم نحصل على أى عقود للعميل
                                            </th>
                                        </tr>
                                    </table>
                                @endif
                                @foreach ($client->contracts as $cc => $item)
                                    <table class="w-100 subtable">

                                        <tr>
                                            <th>الرقم المسلسل:</th>
                                            <td><a
                                                    href="{{ route('contract.view', [$item->id, 1]) }}">{{ $item->s_number }}</a>
                                            </td>
                                            <th>البداية من:</th>
                                            <td>{{ $item->starts_in_hij }}</td>
                                            <th>النهاية فى:</th>
                                            <td>{{ $item->ends_in_hij }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">طبالى العقد</th>
                                            <th colspan="2">الطبالى المشغولة</th>
                                            <th colspan="2">رصيد الطبالى</th>
                                        </tr>
                                        <tr>
                                            <th>كبيرة</th>
                                            <th>صغيرة</th>
                                            <th>كبيرة</th>
                                            <th>صغيرة</th>
                                            <th>كبيرة</th>
                                            <th>صغيرة</th>
                                        </tr>
                                        <tr>
                                            <td>{{ $cl = $item->largePallets }}</td>
                                            <td>{{ $cs = $item->smallPallets }}</td>
                                            <td class="{{ $cl < $item->largeFilled ? 'bg-danger' : '' }}">
                                                {{ $fl = $item->largeFilled }}</td>
                                            <td class="{{ $cs < $item->smallFilled ? 'bg-danger' : '' }}">
                                                {{ $fs = $item->smallFilled }}</td>
                                            <td class="{{ $cl - $fl < 0 ? 'bg-danger' : '' }}">{{ $cl - $fl }}
                                            </td>
                                            <td class="{{ $cs - $fs < 0 ? 'bg-danger' : '' }}">{{ $cs - $fs }}
                                            </td>
                                        </tr>
                                    </table>
                                @endforeach

                            </td>

                            <td>More...</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="5">لا يوجد عملاء مضافين حتى الان</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        {{ $clients->links() }}
    </div>

</div>

<br>
