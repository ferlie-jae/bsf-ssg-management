@extends('layouts.website')
@section('style')
<style>
    table.officers tr td {
        margin: 0 !important;
        padding: 0 !important;
        font-size: 16px;
        font-weight: 300
    }
    table.officers tr th {
        margin: 0 !important;
        padding: 0 !important;
        font-size: 16px;
        font-weight: 400
    }
</style>
@endsection
@section('content')
<div class="p-5 text-center bg-image" style="background-image: url('{{ asset('images/website/campus-officials-banner.jpg') }}');height: 300px;">
    <div class="mask" style="background-color: rgba(0, 0, 0, 0.7);">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="text-white">
            <h1 class="mb-3">Campus Officials</h1>
            {{-- <h4 class="mb-3">asd</h4> --}}
            {{-- <a class="btn btn-outline-light btn-lg" href="#!" role="button"
            >Call to action</a
            > --}}
            </div>
        </div>
    </div>
</div>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="form-group text-center">
                <h4 class="mb-0">
                    Ferdinand S. Bravo
                </h4>
                <p>
                    School Principal IV
                </p>
            </div>
            <div class="form-group text-center mb-5">
                <h4 class="mb-0">
                    Engr. Rockey Ismael G. Nicolas
                </h4>
                <p>
                    Assistant School Principal II
                </p>
            </div>
            <div class="form-group mb-5">
                <h5 class="mb-2 text-center">
                    Senior High School
                </h5>
                <table class="officers table table-sm table-borderless text-center">
                    <tr>
                        <td>Asuncion, Teddy B.</td>
                        <td>Flores, Emelyn S.</td>
                    </tr>
                    <tr>
                        <td>Bravo, Mylene B.</td>
                        <td>Malicdem, Rachel J.</td>
                    </tr>
                    <tr>
                        <td>Castro, Reah B.</td>
                        <td>Manaois, Jennylyn S.</td>
                    </tr>
                    <tr>
                        <td>Castro, Vanessa S.</td>
                        <td>Ramos, Belinda V.</td>
                    </tr>
                    <tr>
                        <td>Cruz, Daniel B.</td>
                        <td>Soriano, Jaime Jr. S.</td>
                    </tr>
                    <tr>
                        <td>Cruz, Jennifer B.</td>
                        <td>Siriano, Liza R.</td>
                    </tr>
                    <tr>
                        <td>De Vera, Benilda D.</td>
                        <td>Tungpalan, Marilyn T.</td>
                    </tr>
                    <tr>
                        <td>Dela Cena, Aida C.</td>
                        <td>Villapa, Ronnie R.</td>
                    </tr>
                    <tr>
                        <td>Fernandez, Eric John T.</td>
                        <td>Vila, Shiella F.</td>
                    </tr>
                </table>
            </div>
            <div class="form-group mb-5">
                <h5 class="mb-2 text-center">
                    Science Department
                </h5>
                <table class="officers table table-sm table-borderless text-center">
                    <tr>
                        <th>Rosario, Manilyn M. - Head Teacher III</th>
                        <td>Castillo, Almer M.</td>
                    </tr>
                    <tr>
                        <td>Baniqued, Pepito</td>
                        <td>Gabrillo, Sonny Sylvester</td>
                    </tr>
                    <tr>
                        <td>Baniqued, Rolly</td>
                        <td>Laureano, Rochelle DS.</td>
                    </tr>
                    <tr>
                        <td>Bravo, Armida E.</td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <div class="form-group mb-5">
                <h5 class="mb-2 text-center">
                    Math Department
                </h5>
                <table class="officers table table-sm table-borderless text-center">
                    <tr>
                        <th>Tarog, Arvi A. - Head Teacher III</th>
                        <td>Pasiliao, Almer M.</td>
                    </tr>
                    <tr>
                        <td>De Leon, Jovel DG.</td>
                        <td>Rosario, Rosario, Jojo Jose G.</td>
                    </tr>
                    <tr>
                        <td>Erolin, Noriele A.</td>
                        <td>Zarate, Rochelle DS.</td>
                    </tr>
                    <tr>
                        <td>Moyano, Jomari</td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <div class="form-group mb-5">
                <h5 class="mb-2 text-center">
                    Communication Arts Department
                </h5>
                <table class="officers table table-sm table-borderless text-center">
                    <tr>
                        <th>Martin, Maria Lusia V.</th>
                        <td>Lopez, Bonemi Grace C.</td>
                    </tr>
                    <tr>
                        <td>Bautista, Shiela Mae S.</td>
                        <td>Mejia, Sandra D.</td>
                    </tr>
                    <tr>
                        <td>Bejar, Danilo Jr. S.</td>
                        <td>Ponasi, Rachelle A.</td>
                    </tr>
                    <tr>
                        <td>Buenafe, Jesabel P.</td>
                        <td>Torio, Wilson B.</td>
                    </tr>
                    <tr>
                        <td>Caña, Debbie B.</td>
                        <td>Sison, Bea Patricia T.</td>
                    </tr>
                    <tr>
                        <td>De Vera, Jocelyn A.</td>
                        <td>Soriano, Jennifer B.</td>
                    </tr>
                    <tr>
                        <td>Fabia, Jonald Q.</td>
                        <td>Vizarra, Jennifer M.</td>
                    </tr>
                </table>
            </div>
            <div class="form-group mb-5">
                <h5 class="mb-2 text-center">
                    MAPVE Department
                </h5>
                <table class="officers table table-sm table-borderless text-center">
                    <tr>
                        <th>Matabang, Marianne D. - Head Teacher III</th>
                        <td>Mangonon, Janeva M.</td>
                    </tr>
                    <tr>
                        <td>Aranda, Wilfredo Jr. A</td>
                        <td>Nakihid, Mariam DL.</td>
                    </tr>
                    <tr>
                        <td>Bangsal, Milanie D.</td>
                        <td>Ocampo, Benedict Ff</td>
                    </tr>
                    <tr>
                        <td>Basa, Sherryl M.</td>
                        <td>Ocampo, Mary Anne M.</td>
                    </tr>
                    <tr>
                        <td>Budol, Karen Grace G.</td>
                        <td>Soriano, Chennie Rose M.</td>
                    </tr>
                    <tr>
                        <td>De Guzman, Cherry D.</td>
                        <td>Soriano, Gilbert DV.</td>
                    </tr>
                    <tr>
                        <td>De Guzman, Maria Cecilia D.</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>De Guzman, Rommel R.</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Donato, Candice A.</td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <div class="form-group mb-5">
                <h5 class="mb-2 text-center">
                    TVE Department
                </h5>
                <table class="officers table table-sm table-borderless text-center">
                    <tr>
                        <th>Mangonon, Naida M. - Head Teacher III</th>
                        <td>Domantay, Sydney V.</td>
                    </tr>
                    <tr>
                        <td>Aquino, Sharon D.</td>
                        <td>Estacio, Elizabeth A.</td>
                    </tr>
                    <tr>
                        <td>Beltran, Ann Kristel D.</td>
                        <td>Estimada, Mclarence P.</td>
                    </tr>
                    <tr>
                        <td>Bonifacio, Jerry L.</td>
                        <td>Evangelista, Geneshir C.</td>
                    </tr>
                    <tr>
                        <td>Bravo, Fructuoso Jr. S.</td>
                        <td>Mejia, Hadjilaine D.</td>
                    </tr>
                    <tr>
                        <td>Cabrera, Kent E.</td>
                        <td>Ramos, Jennifer S.</td>
                    </tr>
                    <tr>
                        <td>Calamiong, Francisca E.</td>
                        <td>Sanches, Alicia M.</td>
                    </tr>
                    <tr>
                        <td>Cerezo, Alwin D.</td>
                        <td>Silang, Christopher A.</td>
                    </tr>
                    <tr>
                        <td>De Guzman, Mary Ann</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>De Guzman, Sylvia A.</td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <div class="form-group mb-5">
                <h5 class="mb-2 text-center">
                    TVE Department
                </h5>
                <table class="officers table table-sm table-borderless text-center">
                    <tr>
                        <th>Aquino, Liezl S. - Adm. Officer II</th>
                        <td>Liquiran, Marife C.</td>
                    </tr>
                    <tr>
                        <td>Angchico, Arlene S.</td>
                        <td>Maron, Cristita C.</td>
                    </tr>
                    <tr>
                        <td>Aquino, Geronimo F.</td>
                        <td>Mejia, Jorge S.</td>
                    </tr>
                    <tr>
                        <td>Bejar, Danilo L.</td>
                        <td>Montemayor, Beto G.</td>
                    </tr>
                    <tr>
                        <td>Beltran, Ricky M.</td>
                        <td>Pajarito, Lorenzo Jr. C.</td>
                    </tr>
                    <tr>
                        <td>Bravo, Filipina M.</td>
                        <td>Payumo, Elvis C.</td>
                    </tr>
                    <tr>
                        <td>Bravo, Khit V.</td>
                        <td>Rosario, Armie B.</td>
                    </tr>
                    <tr>
                        <td>De Leon, Marly E.</td>
                        <td>Salazar, Galen B.</td>
                    </tr>
                    <tr>
                        <td>Dominno, Mercy B.</td>
                        <td>Sanchez, Gerardo B.</td>
                    </tr>
                    <tr>
                        <td>Fernandez, Arturo A.</td>
                        <td>Torio, Aida B.</td>
                    </tr>
                    <tr>
                        <td>Garcia, Bernadette M.</td>
                        <td>Vidal, Elias Jr. S.</td>
                    </tr>
                    <tr>
                        <td>Garcia, Juanito M.</td>
                        <td>Jugo, Rey C.</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Narvasa, Rolando</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection