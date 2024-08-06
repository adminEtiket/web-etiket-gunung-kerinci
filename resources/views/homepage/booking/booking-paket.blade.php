@extends('homepage.template.index')


@section('css')
    <style>
        .pdf-container {
            max-width: 700px;
            width: 100%;
        }

        .header-bg {
            position: relative;
            background: url("{{ asset('assets/img/bg/title-header-bg.png') }}") no-repeat;
            background-size: cover;
            background-position: 50% 50%;
            color: white;
        }


        .header-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            /* Adjust the alpha value for the desired opacity */
            z-index: 1;
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .border-between {
            border-top: 2px solid white;
            width: 50px;
            margin: 20px 0;
        }
    </style>
@endsection

@section('main')
    @include('homepage.template.header', [
        'title' => 'Pendakian Gunung Kerinci',
        'caption' => '.',
    ])

    <script>
        console.log(@json($tiket));
    </script>

    <div class="container my-5">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-7 ">
                <div id="carouselExample" class="carousel slide">
                    <div class="carousel-inner">

                        @foreach ($gambar as $g)
                            <div class="carousel-item {{ $loop->index == 0 ? 'active' : ''}}">
                                <img src="{{ url('/').'/'.$g->src }}" class="d-block w-100" style=";object-fit: cover;height: 480px;" alt="...">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-lg-5 mt-3 mt-lg-0">
                <form method="post" action="{{ route('homepage.postBooking') }}">
                    @csrf
                    <h4 class="mb-4">Booking Tiket Pendakian {{$destinasi->nama}}</h4>

                    <input type="hidden" name="id" value="1">
                    <div class="form-group">
                        <label for="date-start">Pilih tanggal check-in dan check-out</label>
                        <div class="row" id="iptdatevol">
                            <div class="col-md-6 mb-3">
                                <div id="date-start" onclick="generateDate('date-start-value','tanggal-start-label');" class="w-full cursor-pointer btn btn-outline-secondary p-2 rounded d-flex justify-content-between" style="border: 1px solid var(--neutrals300)">
                                    <div id="tanggal-start-label">dd/mm/yy</div>
                                    <img src="{{ asset('assets/icon/tnks/date-dark.svg')}}"></img>
                                    <input type="hidden" class="" name="date_start" id="date-start-value" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div id="date-end" onclick="generateDate('date-end-value','tanggal-end-label');" class="w-full cursor-pointer btn btn-outline-secondary p-2 rounded d-flex justify-content-between" style="border: 1px solid var(--neutrals300)">
                                    <div id="tanggal-end-label">dd/mm/yy</div>
                                    <img src="{{ asset('assets/icon/tnks/date-dark.svg')}}"></img>
                                    <input type="hidden" class="" name="date_end" id="date-end-value" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group py-2">
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label p-0 m-0">Jenis Tiket</label>
                                <div class="dropdown w-100">
                                    <button class="btn btn-outline gk-text-neutrals700 w-100 text-start d-flex justify-content-between  align-items-center dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-color: var(--neutrals700);overflow-x:hidden;">
                                        <div  id="jenis-tiket" style="overflow-x:hidden;">Pilih Jenis Tiket</div>
                                    </button>
                                    <ul class="dropdown-menu"  aria-labelledby="destinasi">
                                        <li>
                                            <a class="dropdown-item" onclick="changeLabelThroughJenisTiket(event, 'jenis-tiket','jenis-tiket-value', '1')" href="#">
                                                <span>Umum</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" onclick="changeLabelThroughJenisTiket(event, 'jenis-tiket','jenis-tiket-value', '2')" href="#">
                                                <span>Rombongan Pelajar (Min 10)</span>
                                            </a>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <input id="jenis-tiket-value" name="jenis_tiket" type="hidden" value="1"/>
                    </div>

                    <div class="form-group">
                        <label>Total Pendaki</label>
                        <label class="text-sm gk-text-neutrals500" style="font-style: italic;" >Estimasi Harga</label>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label for="wni">WNI: <span id="price-for-wni"  ></span></label>
                                <div class="input-group mb-1 inputVolume1" data-price-weekday="" data-price-weekend="">
                                    <button class="btn btn-outline-secondary" type="button" data-input-vol="ipt+" onclick="wniInc(event)">+</button>
                                    <input type="number" class="form-control" name="wni" id="wni" placeholder="Jumlah WNI" required value="0" readonly>
                                    <button class="btn btn-outline-secondary" type="button" data-input-vol="ipt-" onclick="wniDec(event)">-</button>
                                </div>
                                <label for="wna">WNA:  <span id="price-for-wna"></span></label>
                                <div class="input-group mb-1 inputVolume1" data-price-weekday="" data-price-weekend="">
                                    <button class="btn btn-outline-secondary" type="button" data-input-vol="ipt+" onclick="wnaInc(event)">+</button>
                                    <input type="number" class="form-control" name="wna" id="wna" placeholder="Jumlah WNA" required value="0" readonly>
                                    <button class="btn btn-outline-secondary" type="button" data-input-vol="ipt-" onclick="wnaDec(event)">-</button>
                                </div>
                                <div>
                                    <label for="totalharga">Total Harga</label>
                                    <p style="font-size: 11px;" id="labeliptvol">*0 hari 0 malam (2D1N)</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 ">
                                <br>
                                <div class="card ">
                                    <div class="card-body p-2">
                                        <p>
                                            Rp. <span class="iptvol" id="wniTotal">000</span>
                                        </p>
                                        <br>
                                        <p class="mb-0">
                                            Rp. <span class="iptvol" id="wnaTotal">000</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="m-2">
                                    <p>
                                        Rp. <span id="hargaTotal">000</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=" form-group row">
                        <div class="col-6">
                            <label class="form-label p-0 m-0">Gerbang Masuk</label>
                            <div class="dropdown w-100">
                                <button class="btn btn-outline gk-text-neutrals700 w-100 text-start d-flex justify-content-between  align-items-center dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-color: var(--neutrals700);overflow-x:hidden;">
                                    <div  id="gerbang_masuk" style="overflow-x:hidden;">Pilih Gerbang Masuk</div>
                                </button>
                                <ul class="dropdown-menu"  aria-labelledby="destinasi">
                                    @foreach ($destinasi->gates as $d)
                                        <li>
                                            <a class="dropdown-item" onclick="select(event, 'gerbang_masuk','gerbang-masuk-value', 'wna')" href="#">
                                                <span>{{$d->nama}}</span>
                                                <span class="d-none" id="gerbang-masuk-id"></span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <input type="hidden" name="gerbang_masuk" id="gerbang-masuk-value">
                        </div>
                        <div class="col-6">
                            <label class="form-label p-0 m-0">Gerbang Keluar</label>
                            <div class="dropdown w-100">
                                <button class="btn btn-outline gk-text-neutrals700 w-100 text-start d-flex justify-content-between  align-items-center dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-color: var(--neutrals700);overflow-x:hidden;">
                                    <div  id="gerbang_keluar" style="overflow-x:hidden;">Pilih Gerbang Masuk</div>
                                </button>
                                <ul class="dropdown-menu"  aria-labelledby="destinasi">
                                    @foreach ($destinasi->gates as $d)
                                        <li>
                                            <a class="dropdown-item" onclick="select(event, 'gerbang_keluar','gerbang-keluar-value', 'wna')" href="#">
                                                <span>{{$d->nama}}</span>
                                                <span class="d-none" id="gerbang-keluar-id"></span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <input type="hidden" name="gerbang_keluar" id="gerbang-keluar-value">
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary w-100">Lanjut Booking</button>
                    </div>
                    @if ($errors->any())
                        <div class="row gap-1">
                            @foreach ($errors->all() as $error)
                                <div class="row btn btn-danger">
                                    {{ $error }}
                                </div>
                            @endforeach
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div id="modal-date-container" class="px-2 m-0 d-none justify-content-center align-items-center w-screen h-screen position-fixed top-0 left-0" style="z-index: 999; background-color: rgba(0,0,0,.2);">
        <div style="max-width: 500px; " class="m-0 w-full h-fit bg-white rounded d-flex flex-column justify-content-between">
            <div class="w-full h-full">
                <header class="d-flex align-items-center justify-content-between p-2" style="border-bottom: 1px solid var(--neutrals100)">
                    <div class=""><span id="date-month">August</span> <span id="date-year">2019</span></div>
                    <div class="d-flex gap-2">
                        <div id="date-prev" class="d-block gk-bg-neutrals100 rounded px-1 p-0 m-0 d-flex justify-content-center" onclick="prevMonth()"><i class="p-0 m-0 bi bi-arrow-left-short text-2xl" style=""></i></div>
                        <div id="date-next" class="d-block gk-bg-neutrals100 rounded px-1 p-0 m-0 d-flex justify-content-center" onclick="nextMonth()"><i class="p-0 m-0 bi bi-arrow-right-short text-2xl" style=""></i></div>
                    </div>
                </header>
                <table class="row p-2 row justify-content-center py-3">
                    <thead>
                        <tr class="row justify-content-center text-center">
                            <th class="col font-medium gk-text-neutrals500">S</th>
                            <th class="col font-medium gk-text-neutrals500">M</th>
                            <th class="col font-medium gk-text-neutrals500">T</th>
                            <th class="col font-medium gk-text-neutrals500">W</th>
                            <th class="col font-medium gk-text-neutrals500">T</th>
                            <th class="col font-medium gk-text-neutrals500">F</th>
                            <th class="col font-medium gk-text-neutrals500">S</th>
                        </tr>
                    </thead>
                    <tbody id="date-body">
                    </tbody>
                </table>
            </div>
            <footer class="d-flex align-items-center justify-content-between p-2" style="border-top: 1px solid var(--neutrals100)">
                <div>* Merah berarti penuh</div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary gk-bg-primary700 font-medium" id="select-date">Pilih tanggal</button>
                    <button class="btn btn-secondary gk-bg-neutrals200 font-medium text-black" onclick="closeDate()">Batal</button>
                </div>
            </footer>
        </div>
    </div>
@endsection

@section('js')
    <script>

        function refresh() {
            if (!document.getElementById("date-start-value").value || !document.getElementById("date-end-value").value) {
                return;
            }
            const harga = @json($tiket);

            const kategori_hari = isWeekend(document.getElementById("date-start-value").value) ? "wk" : "wd";
            const jenis_tiket = document.getElementById("jenis-tiket-value").value;

            const wniLabel = document.getElementById("wniTotal");
            const wniPendaki = document.getElementById("wni");
            const wniPrice = document.getElementById("price-for-wni").textContent = harga.filter(o => {
                if (o.kategori_hari === kategori_hari && o.kategori_pendaki === "wni" && o.paket_tiket.id === parseInt(jenis_tiket)  ) {
                    return o;
                }
            })[0].harga_masuk;;

            const wnaLabel = document.getElementById("wnaTotal");
            const wnaPendaki = document.getElementById("wna");
            const wnaPrice = document.getElementById("price-for-wna").textContent = harga.filter(o => {
                if (o.kategori_hari === kategori_hari && o.kategori_pendaki === "wna" && o.paket_tiket.id === parseInt(jenis_tiket)  ) {
                    return o;
                }
            })[0].harga_masuk;;


            const hargaTotal = document.getElementById("hargaTotal");

            wniLabel.textContent = wniPendaki.value * harga.filter(o => {
                if (o.kategori_hari === kategori_hari && o.kategori_pendaki === "wni" && o.paket_tiket.id === parseInt(jenis_tiket)  ) {
                    return o;
                }
            })[0].harga_masuk;

            wnaLabel.textContent = wna.value * harga.filter(o => {
                if (o.kategori_hari === kategori_hari && o.kategori_pendaki === "wna" && o.paket_tiket.id === parseInt(jenis_tiket)  ) {
                    return o;
                }
            })[0].harga_masuk;

            hargaTotal.textContent = parseInt(wniLabel.textContent)+parseInt(wnaLabel.textContent);
            console.log("Refreshed");
        }

        function changeLabelThroughJenisTiket(event, callerId, inputId, value) {
            select(event, callerId, inputId, value);
            refresh();
        }

        function select(event, callerId, inputId, value) {
            const caller = document.getElementById(callerId);
            const input = document.getElementById(inputId);

            caller.textContent = event.target.textContent;
            input.value = value;


        }

        const currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();
        let currentDay = currentDate.getDate();
        const months = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ];

        function totalChange() {
            const wniLabel = document.getElementById("wniTotal");
            const wnaLabel = document.getElementById("wnaTotal");
            const hargaTotal = document.getElementById("hargaTotal");

            // Convert text content to numbers, handling potential NaN
            const wniValue = parseInt(wniLabel.textContent) || 0;
            const wnaValue = parseInt(wnaLabel.textContent) || 0;

            // Calculate and set the total
            const total = wniValue + wnaValue;
            hargaTotal.textContent = total;
        }

        function wniInc(event) {
            if (document.getElementById("date-start-value").value && document.getElementById("date-end-value").value) {
                document.getElementById("wni").value++;
                refresh();
            }

        }

        function wniDec(event) {
            if (document.getElementById("wni").value <= 0) {
                return;
            }
            if (document.getElementById("date-start-value").value && document.getElementById("date-end-value").value) {
                document.getElementById("wni").value--;
                refresh();
            }

        }

        function wnaInc(event) {
            if (document.getElementById("date-start-value").value && document.getElementById("date-end-value").value) {
                document.getElementById("wna").value++;
                refresh();
            }

        }

        function wnaDec(event) {
            if (document.getElementById("wna").value <= 0) {
                return;
            }
            if (document.getElementById("date-start-value").value && document.getElementById("date-end-value").value) {
                document.getElementById("wna").value--;
                refresh();
            }

        }

        function generateDate(inputId, labelId) {
            const datePrev = document.getElementById("date-prev");
            if (currentMonth === currentDate.getMonth()) {
                datePrev.classList.add("d-none");
                datePrev.classList.remove("d-block");
            } else {
                datePrev.classList.add("d-block");
                datePrev.classList.remove("d-none");
            }
            const dateContainer = document.getElementById("modal-date-container");
            dateContainer.classList.add("d-flex");
            dateContainer.classList.remove("d-none");
            const year = currentYear;
            const month = currentMonth;
            const day = currentDay;
            const dateMonth = document.getElementById("date-month").textContent = months[month];
            const dateYear = document.getElementById("date-year").textContent = year;
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            const row = Math.floor(daysInMonth/7);
            const dayStart = getDayOfWeek(1, month, year);


            const dataBody = document.getElementById("date-body");
            let count = 0;
            let tr = document.createElement("tr");
            tr.classList.add(...("row justify-content-center text-center mt-2 week-row".split(" ")));
            for (i = 0; i < dayStart;i++) {
                const td = document.createElement("td");
                td.classList.add(...("col font-medium gk-text-neutrals500".split(" ")));
                td.textContent = ``;
                tr.appendChild(td);
            }

            for (i = 0; i < daysInMonth; i++) {
                const td = document.createElement("td");
                const div = document.createElement("div");
                div.textContent = `${i+1}`;
                if (currentMonth === currentDate.getMonth() && i+1 === currentDate.getDate() && currentYear === currentDate.getFullYear() || i+1 === currentDay) {
                    div.classList.add("border", "border-primary", "gk-bg-primary700", "text-white", "rounded-pill");
                }
                td.appendChild(div)
                td.classList.add(...("col font-medium gk-text-neutrals500".split(" ")));
                td.style.cursor="pointer";

                td.addEventListener("click", function(event) {
                    document.querySelectorAll(".week-row").forEach(o => {
                        const tableData = o.querySelectorAll(".border .border-primary, .gk-bg-primary700, .text-white, .rounded-pill");
                        if (tableData.length > 0) {
                            tableData[0].classList.remove("border", "border-primary", "gk-bg-primary700", "text-white", "rounded-pill");
                        }
                    });
                    td.querySelector("div").classList.add("border", "border-primary", "gk-bg-primary700", "text-white", "rounded-pill");
                    currentDay = td.textContent;
                });


                tr.appendChild(td);
                if ((i+1+dayStart) % 7 === 0 || i === daysInMonth-1) {
                    dataBody.appendChild(tr);
                    tr = document.createElement("tr");
                    tr.classList.add(...("row justify-content-center text-center mt-2 week-row".split(" ")));
                }
            }

            const lastWeek = Array.from(document.querySelectorAll(".week-row")).slice(-1)[0];
            const dataInLastWeek = lastWeek.querySelectorAll("td");
            if (dataInLastWeek.length < 7) {
                for (i = 0; i < 7 - dataInLastWeek.length; i++) {
                    const td = document.createElement("td");
                    td.classList.add(...("col font-medium gk-text-neutrals500".split(" ")));
                    td.textContent = ``;
                    lastWeek.appendChild(td);
                }
            }

            const selectButton = document.getElementById("select-date");
            selectButton.onclick = function (event) {
                event.stopPropagation();

                if (inputId === "date-end-value" && parseInt(document.getElementById("date-start-value").value.split("-")[0]) > parseInt(currentDay)) {
                    return;
                }
                const dateLabel = document.getElementById(labelId);
                document.getElementById(inputId).value = `${currentDay}-${currentMonth + 1}-${currentYear}`; // Adjust month to be 1-based
                dateLabel.textContent = `${currentDay}/${currentMonth + 1}/${currentYear}`; // Adjust month to be 1-based
                closeDate();
                refresh();
            };
        }

        function closeDate() {
            const dateContainer = document.getElementById("modal-date-container");
            dateContainer.classList.add("d-none");
            dateContainer.classList.remove("d-flex");
            clearDate();
            currentMonth = currentDate.getMonth();
            currentYear = currentDate.getFullYear();
            currentDay = currentDate.getDate();

        }

        function getDayOfWeek(day, month, year) {
            const date = new Date(year, month, day);
            const dayOfWeekNumber = date.getDay();
            return dayOfWeekNumber;
        }

        function clearDate() {
            const weekRow = document.querySelectorAll(".week-row");
            weekRow.forEach(element => {
                element.remove();
            });
        }

        function prevMonth() {
            if (currentMonth-1 < currentDate.getMonth()) {
                return;
            }
            clearDate();
            currentMonth = (currentMonth-1);
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            generateDate();
        }

        function nextMonth() {
            clearDate();
            currentMonth = (currentMonth+1);
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            generateDate();
        }

        function isWeekend(dateString) {
            let parts = dateString.split('-');
            let date = new Date(parts[2], parts[1] - 1, parts[0]);
            let dayOfWeek = date.getDay();
            return (dayOfWeek === 6) || (dayOfWeek === 0);
        }

    </script>
@endsection
