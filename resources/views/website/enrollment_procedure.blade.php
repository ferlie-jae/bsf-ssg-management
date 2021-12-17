@extends('layouts.website')
@section('style')

@endsection
@section('content')
<div class="p-5 text-center bg-image" style="background-image: url('{{ asset('images/website/enrollment-procedure-banner.jpg') }}');height: 300px;">
    <div class="mask" style="background-color: rgba(0, 0, 0, 0.7);">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="text-white">
                <h1 class="mb-3">Enrollment Procedure</h1>
                {{-- <h4 class="mb-3">asd</h4> --}}
                {{-- <a class="btn btn-outline-light btn-lg" href="https://docs.google.com/forms/d/e/1FAIpQLSfSOdBevFZni3iK7W4qbGSZnLZ1ZyJrvZEWrOPXwwCuK6Ezlg/viewform?fbclid=IwAR3UCbBbtvUT_2T6utN_9J0m1t9OguyarwAIn783Dx4sWfp-3Y0F-qj6XNo" role="button" target="_blank">Enroll Now</a> --}}
            </div>
        </div>
    </div>
</div>
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <h4>A. ONLINE via GOOGLE FORM</h4>
            <ol>
                <li>
                    I- click lamang ang link sa ibaba at punan ang impormasyong kinakailangan. 
                    <br>
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSd464FDEij2N7c98x7qxHttkEAbp3VL-2asjSdV-2xGLLUM8Q/viewform" target="_blank">https://forms.gle/hpe1UtT9BNxbuZoB6</a>
                </li>
                <li>
                    Para sa mga incoming Grade 8 to Grade 12, i-click lamang ang NEXT sa google form upang itala ang napiling STVEP SPECIALIZATION at TRACK/STRAND naman para sa mga SHS. 
                </li>
            </ol>
            <h4>B. ONLINE via FACEBOOK PAGE CHAT</h4>
            <ul style="list-style: none">
                <li>
                    I-search ang FB Page ng paaralan (DepEd Tayo Binmaley SoF 300232) at i-MESSAGE ang iyong Personal Information:
                    <li><a href="https://www.facebook.com/DepEdTayoBinmaleySOF300232" target="_blank">Facebook Page link</a></li>
                </li>
                <li>
                    <ol>
                        <li>Full Name</li>
                        <li>Grade Level</li>
                        <li>Date of Birth</li>
                        <li>Home Address</li>
                        <li>Specialization (For incoming Grade 8)</li>
                        <li>Track/Strand (For incoming Grade 11)</li>
                    </ol>
                </li>
            </ul>
            <h4>C. Through TEXT MESSAGE</h4>
            <ul style="list-style: none">
                <li>
                    Punan ang iyong Personal Information:
                    <ol>
                        <li>Full Name</li>
                        <li>Grade Level</li>
                        <li>Date of Birth</li>
                        <li>Home Address</li>
                        <li>Specialization (for Grade 8- 10)</li>
                        <li>Track/Strand (for Grade 11& 12)</li>
                    </ol>
                </li>
                <li>
                    Ipadala ito sa mga sumusunod na numero:
                    <ul>
                        <li>Grade 7- 09254700187</li>
                        <li>Grade 8- 09194629856</li>
                        <li>Grade 9- 09386889752</li>
                        <li>Grade 10- 09437025093</li>
                        <li>Grade 11- 09474494458</li>
                        <li>Grade 12- 09189191752</li>
                        <li>ALS-BPOSA- 09469556707</li>
                        <li>Transferees & Balik-Aral- 09993082206</li>
                    </ul>
                </li>
            </ul>
            <h4>D. Para sa mga dating mag-aaral ng BSF na incoming Grade 8-10 at Grade 12, maari niyong i-contact ang inyong dating adviser para sa enrollment. </h4>
            <br>
            <p>
                <strong>Paalala:</strong> Hindi pa po kailangang pumunta sa paaralan upang makapagpatala o magpalista para sa ating kaligtasan habang may banta pa ang COVID-19 pandemic. 
            </p>
        </div>
        {{-- <div class="col-lg-6">
            <h4>A. ONLINE ENROLLMENT (through google forms)</h4>
            <ol>
                <li>
                    For Grade 7 & 11, Transferees, at Balik-Aral learners
                    <br>
                    I- click lamang ang link at punan ang impormasyong kinakailangan.
                    <br>
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSfSOdBevFZni3iK7W4qbGSZnLZ1ZyJrvZEWrOPXwwCuK6Ezlg/viewform?fbclid=IwAR3T_AKVU3kUK5AnTkpGLDp05JAmEZVqCHB96nqS22TNHCFFu-XpMG07Vr8" target="_blank">Google Forms</a>
                </li>
                <li>
                    For incoming Grade 8 with TVE SPECIALIZATION
                    <br>
                    I- click lamang ang link at punan ang impormasyong kinakailangan.
                    <br>
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSfYDNiXqwCKfNixlHSDvM1Xd4E5Z1oGu_rcdHXNV_hfkh4GKA/viewform?fbclid=IwAR3i9A0qKWplDMPS0Wx1urUTUUxIPC-ML4bxhKw_ZqDHlxTMvN32gyddumk" target="_blank">Google Forms</a>
                </li>
            </ol>
            <h4>B. ONLINE ENROLLMENT (through facebook chat)</h4>
            <ul style="list-style: none">
                <li>
                    I-search ang FB Page ng paaralan (DepEd Tayo Binmaley SoF 300232) at i-MESSAGE ang iyong Personal Information:
                    <li><a href="https://www.facebook.com/DepEdTayoBinmaleySOF300232" target="_blank">Facebook Page link</a></li>
                </li>
                <li>
                    <ol>
                        <li>Full Name</li>
                        <li>Grade Level</li>
                        <li>Date of Birth</li>
                        <li>Home Address</li>
                        <li>Specialization (For incoming Grade 8)</li>
                        <li>Track/Strand (For incoming Grade 11)</li>
                    </ol>
                </li>
            </ul>
            
            <h4>C. ENROLLMENT through TEXT MESSAGE</h4>
            <ul>
                <li>
                    Punan ang iyong Personal Information:
                    <ol>
                        <li>Full Name</li>
                        <li>Grade Level</li>
                        <li>Date of Birth</li>
                        <li>Home Address</li>
                        <li>Specialization (For incoming Grade 8)</li>
                        <li>Track/Strand (For incoming Grade 11)</li>
                    </ol>
                </li>
                <li>
                    Ipadala ito sa mga sumusunod na numero:
                    <ul>
                        <li>JHS (Grade 7)- 09436277066</li>
                        <li>JHS (Grade 8)- 09420309907</li>
                        <li>SHS (Grade 11)- 09273009381</li>
                        <li>ALS-BPOSA- 09469556707</li>
                        <li>Transferees & Balik-Aral- 09993082206</li>
                    </ul>
                </li>
            </ul>
            <h4>D. Maaari kayong magpatulong sa kakilala o kapitbahay niyong guro ng Binmaley School of Fisheries hinggil sa enrollment</h4>
            <br>
            <p>
                <strong>Paalala:</strong> Hindi pa po kailangang pumunta sa paaralan upang makapagpatala o magpalista para sa ating kaligtasan habang may banta pa ang COVID-19 pandemic. Hanggang June 30, 2020 ang enrollment.
            </p>
        </div> --}}
    </div>
</div>
@endsection
@section('script')

@endsection