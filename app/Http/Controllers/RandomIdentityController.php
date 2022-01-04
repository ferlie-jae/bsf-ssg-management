<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Configuration\Section;
use App\Models\StudentSection;
use App\Models\Faculty;
use App\Models\UserStudent;
use App\Models\UserFaculty;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class RandomIdentityController extends Controller
{
	public function insert_student(Request $request)
	{
		$count = $request->number;
		$date_now = Carbon::now()->toDateTimeString();
		
		// $bar = $this->output->createProgressBar(count($count));
		for ($i=0; $i < $count; $i++) {
			$last_name = $this->lname();
			$middle_name = $this->lname();
			list($brgy, $city, $province) = $this->address();
			list($sex, $fname) = $this->fname();
			$bdate = $this->bdate();
			$studentID = $this->student_id();
			$contactNumber = $this->phone();

			$student = Student::create([
				'student_id' => $studentID,
				'first_name' => $fname,
				'middle_name' => $middle_name,
				'last_name' => $last_name,
				'gender' => $sex,
				'birth_date' => $bdate,
				'contact_number' => $contactNumber,
				'address' => ($brgy == '' ? '' : $brgy . ', ') . $city . ', ' . $province
			]);
			
			$section = Section::inRandomOrder()->first();
			StudentSection::create([
				'student_id' => $student->id,
				'section_id' => $section->id
			]);

			if($request->get('add_account') == 'add_account'){
				// $email = $this->email($student->first_name, $last_name, $student->student_id);
				$user = User::create([
					'username' => $student->student_id,
					'email' => $student->student_id.'@gmail.com',
					'password' => Hash::make('asdasd'),
					'temp_password' => 'asdasd'
				]);
	
				$user->assignRole(4);
				UserStudent::create([
					'user_id' => $user->id,
					'student_id' => $student->id
				]);
			}


		}

		return back();
	}

	public function insert_faculty(Request $request)
	{
		$count = $request->number;
		// $bar = $this->output->createProgressBar(count($count));
		for ($i=0; $i < $count; $i++) {
			list($brgy, $city, $province) = $this->address();
			list($sex, $fname) = $this->fname();

			$first_name = explode(" ", strtolower($fname));
			$fname_acronym = "";
			foreach ($first_name as $letter) {
				$fname_acronym .= $letter[0];
			}

			$lname = $this->lname();
			$mname = $this->lname();

			$bdate = $this->bdate();
			$faculty = Faculty::create([
				'faculty_id' => $this->faculty_id(),
				'first_name' => $fname,
				'middle_name' => $mname,
				'last_name' => $lname,
				'gender' => $sex,
				'birth_date' => $bdate,
				'contact_number' => $this->phone(),
				'address' => ($brgy == '' ? '' : $brgy . ', ') . $city . ', ' . $province
			]);

			if($request->get('add_account') == 'add_account'){
				$email = $this->email($fname, $lname, $faculty->faculty_id);
				$user = User::create([
					'username' => $faculty->faculty_id,
					'email' => $email,
					'password' => Hash::make('asdasd')
				]);
	
				$user->assignRole(3);
				UserFaculty::create([
					'user_id' => $user->id,
					'faculty_id' => $faculty->id
				]);
			}

		}

		return back();
	}

	public function age($bdate){

		// date now
		$d_now = date("d");
		$m_now = date("m");
		$y_now = date("Y");
		// birth date
		$d_bd = date("d", strtotime($bdate));
		$m_bd = date("m", strtotime($bdate));
		$y_bd = date("Y", strtotime($bdate));

		if ($m_bd > $m_now || $d_bd > $d_now & $m_bd >= $m_now){
			$compute = $y_now - $y_bd;
			$age = $compute - 1;
		}
		else {
			$age = $y_now - $y_bd;
		}
		return $age;

	}


	public function student_id()
	{
		$number = mt_rand(100000000, 999999999); // better than rand()


		if ($this->student_id_exist($number)) {
			return student_id();
		}

		// otherwise, it's valid and can be used
		return $number;
	}

	public function faculty_id()
	{
		$number = mt_rand(100000000, 999999999); // better than rand()

		if ($this->faculty_id_exist($number)) {
			return faculty_id();
		}

		// otherwise, it's valid and can be used
		return $number;
	}

	public function student_id_exist($number)
	{
		if(
			Student::where('student_id', $number)->exists()
			|| Faculty::where('faculty_id', $number)->exists()
		){
			return True;
		}else{
			return False;
		}
		// return Student::where('student_id', $number)->exists();
	}

	public function faculty_id_exist($number)
	{
		if(
			Student::where('student_id', $number)->exists()
			|| Faculty::where('faculty_id', $number)->exists()
		){
			return True;
		}else{
			return False;
		}
		// return Faculty::where('faculty_id', $number)->exists();
	}

	/* public function email_exist($email)
	{
		if(
			User::where('email', $email)->exists()
			|| Student::where('email', $email)->exists()
			|| Faculty::where('email', $email)->exists()
		){
			return True;
		}else{
			return False;
		}
	} */

	public function email($fname, $lname, $number)
	{
		$first_name = explode(" ", strtolower($fname));
		$fname_acronym = "";
		foreach ($first_name as $letter) {
			$fname_acronym .= $letter[0];
		}

		$email = $fname_acronym.'.'.strtolower(preg_replace('/\s+/', ' ', $lname)).$number.'@gmail.com';

		return $email;
	}

	public function religion()
	{
		$n = array(
			"Roman Catholic",
			"Jehova's Witness",
			"Iglesia ni Cristo",
			"Buddhists",
			"Islam",
			"Protestant",
		);
		$random = $n[mt_rand(0, sizeof($n) - 1)];
		return $random;

	}

	public function address()
	{
		$n = array(
			'Pangasinan' => array(
				'Alaminos City' => array(
					'Alos',
					'Amandiego',
					'Amangbangan',
					'Balangobong',
					'Balayang',
					'Bisocol',
					'Bolaney',
					'Baleyadaan',
					'Bued',
					'Cabatuan',
					'Cayucay',
					'Dulacac',
					'Inerangan',
					'Landoc',
					'Linmansangan',
					'Lucap',
					'Maawi',
					'Macatiw',
					'Magsaysay',
					'Mona',
					'Palamis',
					'Pandan',
					'Pangapisan',
					'Poblacion',
					'Pocal-Pocal',
					'Pogo',
					'Polo',
					'Quibuar',
					'Sabangan',
					'San Antonio',
					'San Jose',
					'San Roque',
					'San Vicente',
					'Santa Maria',
					'Tanaytay',
					'Tangcarang',
					'Tawintawin',
					'Telbang',
					'Victoria'
				),
				'Sual' => array(
					'Baquioen',
					'Baybay Norte',
					'Baybay Sur',
					'Bolaoen',
					'Cabalitian',
					'Calumbuyan',
					'Camagsingalan',
					'Caoayan',
					'Capantolan',
					'Macaycayawan',
					'Paitan East',
					'Paitan West',
					'Pangascasan',
					'Poblacion',
					'Santo Domingo',
					'Seselangen',
					'Sioasio East',
					'Sioasio West',
					'Victoria'
				),
				'Agno' => array(
					'Allabon',
					'Aloleng',
					'Bangan Oda',
					'Baruan',
					'Boboy',
					'Cayungnan',
					'Dangley',
					'Gayusan',
					'Macaboboni',
					'Magsaysay',
					'Namatucan',
					'Patar',
					'Poblacion East',
					'Poblacion West',
					'San Juan',
					'Tupa',
					'Viga'
				),
				'Aguilar' => array(
					'Bayaoas',
					'Baybay',
					'Bocacliw',
					'Bocboc East',
					'Bocboc West',
					'Buer',
					'Calsib',
					'Niñoy',
					'Poblacion',
					'Pogomboa',
					'Pogonsili',
					'San Jose',
					'Tampac',
					'Laoag',
					'Manlocboc',
					'Panacol'
				),
				'Alcala' => array(
					'Anulid',
					'Atainan',
					'Bersamin',
					'Canarvacanan',
					'Caranglaan',
					'Curareng',
					'Gualsic',
					'Kisikis',
					'Laoac',
					'Macayo',
					'Pindangan Centro',
					'Pindangan East',
					'Pindangan West',
					'Poblacion East',
					'Poblacion West',
					'San Juan',
					'San Nicolas',
					'San Pedro Apartado',
					'San Pedro Ili',
					'San Vicente',
					'Vacante'
				),
				'Anda',
				'Asingan',
				'Balungao',
				'Bani',
				'Basista',
				'Bautista',
				'Bayambang',
				'Binalonan',
				'Binmaley',
				'Bolinao',
				'Bugallon',
				'Burgos',
				'Calasiao',
				'Dasol',
				'Dagupan' => array(
					'Bacayao Norte',
					'Bacayao Sur',
					'Barangay I (T. Bugallon)',
					'Barangay II (Nueva)',
					'Barangay IV (Zamora)',
					'Bolosan',
					'Bonuan Binloc',
					'Bonuan Boquig',
					'Bonuan Gueset',
					'Calmay',
					'Carael',
					'Caranglaan',
					'Herrero',
					'Lasip Chico',
					'Lasip Grande',
					'Lomboy',
					'Lucao',
					'Malued',
					'Mamalingling',
					'Mangin',
					'Mayombo',
					'Pantal',
					'Poblacion Oeste',
					'Pogo Chico',
					'Pogo Grande',
					'Pugaro Suit',
					'Salapingao',
					'Salisay',
					'Tambac',
					'Tapuac',
					'Tebeng'
				),
				'Dasol',
				'Infanta',
				'Labrador' => array(
					'Bolo',
					'Bongalon',
					'Dulig',
					'Laois',
					'Magsaysay',
					'Poblacion',
					'San Gonzalo',
					'San Jose',
					'Tobuan',
					'Uyong'
				),
				'Laoac',
				'Lingayen' => array(
					'Aliwekwek',
					'Baay',
					'Balangobong',
					'Balococ',
					'Bantayan',
					'Basing',
					'Capandanan',
					'Domalandan Center',
					'Domalandan East',
					'Domalandan West',
					'Dorongan',
					'Dulag',
					'Estanza',
					'Lasip',
					'Libsong East',
					'Libsong West',
					'Malawa',
					'Malimpuec',
					'Maniboc',
					'Matalava',
					'Naguelguel',
					'Namolan',
					'Pangapisan North',
					'Pangapisan Sur',
					'Poblacion',
					'Quibaol',
					'Rosario',
					'Sabangan',
					'Talogtog',
					'Tonton',
					'Tumbar',
					'Wawa'
				),
				'Mabini',
				'Malasiqui',
				'Manaoag',
				'Mangaldan',
				'Mangatarem',
				'Mapandan',
				'Natividad',
				'Pozorrubio',
				'Rosales',
				'San Carlos',
				'San Fabian',
				'San Jacinto',
				'San Manuel',
				'San Nicolas',
				'San Quintin',
				'Santa Barbara',
				'Santa Maria',
				'Santo Tomas',
				'Sison',
				'Tayug',
				'Umingan',
				'Urbiztondo',
				'Urdaneta',
				'Villasis',
			)

		);
		$province = array_rand($n);
		$cityRand = array_rand($n[$province]);
		$city = is_array($n[$province][$cityRand]) ? $cityRand : $n[$province][$cityRand];
		$brgy = is_array($n[$province][$cityRand]) ? $n[$province][$cityRand][array_rand($n[$province][$cityRand])] : "";
		
		return array($brgy, $city, $province);

	}

	public function civil_status()
	{
		$n = array(
			'Single',
			// 'Separated',
			// 'Widowed',
			'Married',
			// 'Annuled',
			// 'Divorce',
		);
		$random = $n[mt_rand(0, sizeof($n) - 1)];
		return $random;
	}

	public function bdate()
	{
		$timestamp = mt_rand(1, time());
		return date('Y-m-d', $timestamp);
	}

	public function fname()
	{
		$names = array(
			'Male' => array(
				'Ace',
				'Rayleigh',
				'Joshua',
				'Paul',
				'John',
				'David',
				'David Paul',
				'Johnny',
				'Michael',
				'Anthony',
				'Mark',
				'Lloyd',
				'Carl',
				'Zoro',
				'Daniel',
				'Warren',
				'Ruben',
				'Robert',
				'Diosdado',
				'Dodie',
				'Joseph',
				'Manny',
				'Fredie',
				'Kyle',
				'Dylan',
				'John Paul',
				'Christian',
				'Justine',
				'John Mark',
				'John Lloyd',
				'Jerome',
				'Torrey',
				'Nyjah',
				'Leo',
				'Aron',
				'Ronnie',
				'Ace',
				'Eric',
				'Rico',
				'Francis',
				'Marlon',
				'Dexter',
				'Johnson',
				'Aldrin',
				'Rey',
				'Chester',
				'Reynaldo',
				'Jason',
				'Ken',
				'Ken',
				'Adrian',
				'John Michael',
				'Angelo',
				'Justin',
				'John Carlo',
				'James',
				'Mark',
				'Kenneth',
				'Jayson',
				'Mark Anthony',
				'Daniel',
				'John Rey',
				'Ryan',
			),
			'Female' => array(
				'Dorothy',
				'Jaira Mae',
				'Jaira',
				'Mae',
				'Angel',
				'Angelica',
				'Nicole',
				'Angela',
				'Mary Joy',
				'Mariel',
				'Jasmine',
				'Mary',
				'Grace',
				'Mary Grace',
				'Kimberly',
				'Stephanie',
				'Christine',
				'Michelle',
				'Jessa Mae',
				'Jenny',
				'Apple',
				'Rose',
				'Nami',
				'Robin',
				'Marie',
				'Erica',
				'Andrea',
				'Liza',
				'Elizabeth',
				'Hope',
				'Elizabeth Hope',
				'Kathryn',
				'Coleen',
				'Mia',
				'Pauleen',
				'Ariana Marie',
				'Ariana',
				'Carolina',
				'Ashly',
				'Jane',
				'Jenny',
				'Joy',
				'Sharon',
				'Ruth',
				'Delia',
				'Bernadeth',
				'Denise',
				'Rachelle',
				'Resheal',
				'Precious',
				'Angelica',
				'Maricar',
				'Jehiel',
				'Jehiel',
				'Serena',
				'Maria',
				'Angeline',
				'Erica',
				'Bea',
				'Janelle',
				'Kyla',
				'Althea',
			),
		);
		$sex = array_rand($names);
		$name = $names[$sex][array_rand($names[$sex])];
		/*$random = $names[mt_rand(0, sizeof($names) - 1)];
		return $random;*/
		return array($sex, $name);

	}
	public function random_name()
	{
		$names = array(
			'Joshua',
			'Paul',
			'John',
			'David',
			'David Paul',
			'Johnny',
			'Michael',
			'Anthony',
			'Mark',
			'Lloyd',
			'Carl',
			'Daniel',
			'Warren',
			'Ruben',
			'Robert',
			'Diosdado',
			'Dodie',
			'Joseph',
			'Manny',
			'Fredie',
			'Kyle',
			'Dylan',
			'John Paul',
			'Christian',
			'Justine',
			'John Mark',
			'John Lloyd',
			'Jerome',
			'Torrey',
			'Nyjah',
			'Leo',
			'Aron',
			'Ronnie',
			'Ace',
			'Eric',
			'Rico',
			'Francis',
			'Marlon',
			'Dexter',
			'Johnson',
			'Aldrin',
			'Rey',
			'Chester',
			'Reynaldo',
			'Jason',
			'Ken',
			'Ken',
			'Adrian',
			'John Michael',
			'Angelo',
			'Justin',
			'John Carlo',
			'James',
			'Mark',
			'Kenneth',
			'Jayson',
			'Mark Anthony',
			'Daniel',
			'John Rey',
			'Ryan',
			'Dorothy',
			'Jaira Mae',
			'Jaira',
			'Mae',
			'Angel',
			'Angelica',
			'Nicole',
			'Angela',
			'Mary Joy',
			'Mariel',
			'Jasmine',
			'Mary',
			'Grace',
			'Mary Grace',
			'Kimberly',
			'Stephanie',
			'Christine',
			'Michelle',
			'Jessa Mae',
			'Jenny',
			'Apple',
			'Rose',
			'Marie',
			'Erica',
			'Andrea',
			'Liza',
			'Elizabeth',
			'Hope',
			'Elizabeth Hope',
			'Kathryn',
			'Coleen',
			'Mia',
			'Pauleen',
			'Ariana Marie',
			'Ariana',
			'Carolina',
			'Ashly',
			'Jane',
			'Jenny',
			'Joy',
			'Sharon',
			'Ruth',
			'Delia',
			'Bernadeth',
			'Denise',
			'Rachelle',
			'Resheal',
			'Precious',
			'Angelica',
			'Maricar',
			'Jehiel',
			'Jehiel',
			'Serena',
			'Maria',
			'Angeline',
			'Erica',
			'Bea',
			'Janelle',
			'Kyla',
			'Althea',
		);
		$random = $names[mt_rand(0, sizeof($names) - 1)];
		return $random;

	}
	public function female_name()
	{
		$names = array(
			'Dorothy',
			'Jaira Mae',
			'Jaira',
			'Mae',
			'Angel',
			'Angelica',
			'Nicole',
			'Angela',
			'Mary Joy',
			'Mariel',
			'Jasmine',
			'Mary',
			'Grace',
			'Mary Grace',
			'Kimberly',
			'Stephanie',
			'Christine',
			'Michelle',
			'Jessa Mae',
			'Jenny',
			'Apple',
			'Rose',
			'Marie',
			'Erica',
			'Andrea',
			'Liza',
			'Elizabeth',
			'Hope',
			'Elizabeth Hope',
			'Kathryn',
			'Coleen',
			'Mia',
			'Pauleen',
			'Ariana Marie',
			'Ariana',
			'Carolina',
			'Ashly',
			'Jane',
			'Jenny',
			'Joy',
			'Sharon',
			'Ruth',
			'Delia',
			'Bernadeth',
			'Denise',
			'Rachelle',
			'Resheal',
			'Precious',
			'Angelica',
			'Maricar',
			'Jehiel',
			'Jehiel',
			'Serena',
			'Maria',
			'Angeline',
			'Erica',
			'Bea',
			'Janelle',
			'Kyla',
			'Althea',
		);
		$random = $names[mt_rand(0, sizeof($names) - 1)];
		return $random;
	}

	public function male_name()
	{
		$names = array(
			'Joshua',
			'Paul',
			'John',
			'David',
			'David Paul',
			'Johnny',
			'Michael',
			'Anthony',
			'Mark',
			'Lloyd',
			'Carl',
			'Daniel',
			'Warren',
			'Ruben',
			'Robert',
			'Diosdado',
			'Dodie',
			'Joseph',
			'Manny',
			'Fredie',
			'Kyle',
			'Dylan',
			'John Paul',
			'Christian',
			'Justine',
			'John Mark',
			'John Lloyd',
			'Jerome',
			'Torrey',
			'Nyjah',
			'Leo',
			'Aron',
			'Ronnie',
			'Ace',
			'Eric',
			'Rico',
			'Francis',
			'Marlon',
			'Dexter',
			'Johnson',
			'Aldrin',
			'Rey',
			'Chester',
			'Reynaldo',
			'Jason',
			'Ken',
			'Ken',
			'Adrian',
			'John Michael',
			'Angelo',
			'Justin',
			'John Carlo',
			'James',
			'Mark',
			'Kenneth',
			'Jayson',
			'Mark Anthony',
			'Daniel',
			'John Rey',
			'Ryan',
		);
		$random = $names[mt_rand(0, sizeof($names) - 1)];
		return $random;
	}

	public function lname()
	{
		/*$names = array(
			'Eligio',
			'Ferrer',
			'Anceno',
			'Nisperos',
			'Walker',
			'Doe',
			'Basobas',
			'Chan',
			'Rabanera',
			'Ramiscal',
			'De Guzman',
			'Dela Cruz',
			'Cruz',
			'Sebastian',
			'Reyes',
			'Garcia',
			'Ramirez',
			'Ancheta',
			'Talon',
			'Montemayor',
			'Marcos',
			'Aquino',
			'Cojuangco',
			'Soberano',
			'Gil',
			'Bernardo',
			'Padilla',
			'Del Rosario',
			'Guillermo',
			'Binay',
			'Villar',
			'Roxas',
			'Mabini',
			'Dalisay',
			'Caluag',
			'Agustin',
			'Abella',
			'Arellano',
			'Aragon',
			'Arriola',
			'Beltran',
			'Bello',
			'Balagtas',
			'Bernal',
			'Bonilla',
			'Cardenas',
			'Chua',
			'Collado',
			'Collates',
			'Concepcion',
			'Coquangco',
			'Custudio',
			'Roxas',
			'Escobar',
			'Corpuz',
			'Santos',
			'Arellano',
			'Davidson',
			'Silva',
			'Juarez',
			'Hardin',
			'Jimenez',
			'Farrell',
			'Bradshaw',
			'Maldonado',
			'Rollins',
			'Peterson'
		);*/

		$names = array(
			'Abalorio',
			'Abel',
			'Abelardo',
			'Aballa',
			'Abella',
			'Abellana',
			'Abellanosa',
			'Abellera',
			'Abello',
			'Abellon',
			'Ablog',
			'Agustin',
			'Arbiz',
			'Artuz',
			'Abu',
			'Acebedo',
			'Acosta',
			'Acuña',
			'Adaya',
			'Agbayani',
			'Aguas',
			'Aguila',
			'Aguilar',
			'Aguilera',
			'Aguinaldo',
			'Agustin',
			'Alamares',
			'Alano',
			'Alarcon',
			'Alba',
			'Alcala',
			'Alcantara',
			'Alcazar',
			'Alcoy',
			'Aldana',
			'Aldo',
			'Alegre',
			'Alejandro',
			'Alejos',
			'Alfaro',
			'Alfonso',
			'Alicante',
			'Almonte',
			'Alonzo',
			'Alvarado',
			'Alvarez',
			'Amado',
			'Amante',
			'Amoranto',
			'Ancheta',
			'Andrada',
			'Andrade',
			'Andal',
			'Angeles',
			'Antonio',
			'Aquino',
			'Aragon',
			'Aragones',
			'Arce',
			'Arcebuche',
			'Arcega',
			'Arceo',
			'Arciaga',
			'Arcilla',
			'Arellano',
			'Argente',
			'Arriola',
			'Artiaga',
			'Astilla',
			'Asuncion',
			'Avila',
			'Ayen',
			'Bagcal',
			'Balagtas',
			'Balcita',
			'Balestramon',
			'Balingasa',
			'Ballesteros',
			'Balmaceda',
			'Baño',
			'Baquiran',
			'Barcelona',
			'Barrameda',
			'Barrera',
			'Barrientos',
			'Barrios',
			'Batacan',
			'Bautista',
			'Bello',
			'Belmonte',
			'Beltran',
			'Benitez',
			'Bermudez',
			'Bernal',
			'Bernardez',
			'Bernardo',
			'Biag',
			'Biglete',
			'Bigornia',
			'Bitoon',
			'Bituin',
			'Bolaños',
			'Bolante',
			'Bonilla',
			'Borbon',
			'Borja',
			'Borromeo',
			'Bravo',
			'Briones',
			'Broqueza',
			'Bugayong',
			'Buenaventura',
			'Bumagat',
			'Burcelango',
			'Bueno',
			'Bernal',
			'Cabahug',
			'Cabatu',
			'Cabatuan',
			'Cabanalan',
			'Cabatingan',
			'Cabasag',
			'Cabe',
			'Cabias',
			'Cabiso',
			'Cabusas',
			'Calalang',
			'Calangi',
			'Calderon',
			'Camacho',
			'Campos',
			'Camungao',
			'Canlas',
			'Cansino',
			'Cañete',
			'Capangpangan',
			'Capistrano',
			'Capulong',
			'Carbonell',
			'Cardenas',
			'Cardona',
			'Carimat',
			'Cariño',
			'Carlos',
			'Carmona',
			'Carpio',
			'Carreon',
			'Carsula',
			'Carvajal',
			'Casal',
			'Casanova',
			'Casas',
			'Casida',
			'Castañeda',
			'Castañares',
			'Castillo',
			'Castro',
			'Catabian',
			'Catalan',
			'Catapang',
			'Catungal',
			'Celestial',
			'Ceniza',
			'Cervantes',
			'Chan',
			'Chang',
			'Chavez',
			'Cheng',
			'Ching',
			'Chiong',
			'Chiu',
			'Chua',
			'Claudio',
			'Claveria',
			'Clemente',
			'Co',
			'Collantes',
			'Collado',
			'Coloma',
			'Concepcion',
			'Contreras',
			'Cordero',
			'Cornejo',
			'Corona',
			'Coronel',
			'Corpuz',
			'Costales',
			'Cristobal',
			'Cruz',
			'Cruzado',
			'Cuadro',
			'Cuartero',
			'Cunanan',
			'Custodio',
			'Dacanay',
			'Dacua',
			'Dagohoy',
			'Dalangin',
			'Dalisay',
			'Dandan',
			'Danila',
			'David',
			'Dee',
			'De Castro',
			'De Jesus',
			'De Guzman',
			'De Leon',
			'De Silva',
			'De Vera',
			'Del Castillo',
			'Del Prado',
			'Del Rosario',
			'Del Valle',
			'Dela Cruz',
			'Dela Peña',
			'Dela Rosa',
			'Delacion',
			'Delos Santos',
			'Diaz',
			'Driz',
			'Dimaano',
			'Dimacali',
			'Dimaculangan',
			'Dimagiba',
			'Dimapilis',
			'Dimatatac',
			'Dimatulac',
			'Dimayuga',
			'Dionisio',
			'Dirije',
			'Dizon',
			'Domingo',
			'Dominguez',
			'Donato',
			'Dorado',
			'Duran',
			'Duterte',
			'Dy',
			'Dante',
			'Ebreo',
			'Edralin',
			'Elad',
			'Encarnacion',
			'Endrano',
			'Enojado',
			'Enriquez',
			'Ensano',
			'Escanilla',
			'Esguerra',
			'Espejo',
			'Espeleta',
			'Espina',
			'Espinola',
			'Espinosa',
			'Estrabillo',
			'Estrella',
			'Eusebio',
			'Evangelista',
			'Evangelio',
			'Esguerra',
			'Fabela',
			'Fabila',
			'Fabregas',
			'Feliciano',
			'Fernandez',
			'Fernando',
			'Ferrer',
			'Flores',
			'Fontanilla',
			'Francisco',
			'Franco',
			'Frias',
			'Fuentes',
			'Fulgencio',
			'Falamig',
			'Ga',
			'Gabutan',
			'Gacutan',
			'Gallentes',
			'Galvez',
			'Garcia',
			'Gardiola',
			'Garsuta',
			'Gatdula',
			'Gaviola',
			'Geronimo',
			'Gil',
			'Glemao',
			'Golveo',
			'Gomez',
			'Gopez',
			'Gonowon',
			'Gonzaga',
			'Gonzales',
			'Grospe',
			'Guevarra',
			'Guiting',
			'Gutierrez',
			'Guarra',
			'Guatalamelana',
			'Habaña',
			'Halili',
			'Hernandez',
			'Hidalgo',
			'Hilario',
			'Hipolito',
			'Herminigildo',
			'Hermoso',
			'Hermosa',
			'Hernaez',
			'Ibanez',
			'Ibarra',
			'Ilao',
			'Isidro',
			'Isip',
			'Jacob',
			'Jaranilla',
			'Jadina',
			'Jimenez',
			'Kong',
			'Kalaw',
			'King',
			'Labaton',
			'Lacsamana',
			'La Guardia',
			'Lajom',
			'Lanuza',
			'Lamanilao',
			'Landicho',
			'Landoval',
			'Langit',
			'Lanopa',
			'Lavarias',
			'Ledesma',
			'Legaspi',
			'Libunao',
			'Liwanag',
			'Lopez',
			'Lucero',
			'Luna',
			'Lumbaga',
			'Lazam',
			'Legista',
			'Luzod',
			'Macadaya',
			'Maestrado',
			'Mahilum',
			'Maluping',
			'Macan',
			'Macalinga',
			'Macatangay',
			'Macato',
			'Madrid',
			'Magallanes',
			'Magallon',
			'Magbanua',
			'Magbojos',
			'Maghanoy',
			'Maglente',
			'Malihan',
			'Manabat',
			'Manahan',
			'Mandayonon',
			'Mancenon',
			'Manila',
			'Mangubat',
			'Manzano',
			'Manzon',
			'Maramot',
			'Marcelino',
			'Marcos',
			'Marquez',
			'Martinez',
			'Mata',
			'Mateo',
			'Medina',
			'Mediana',
			'Mejia',
			'Mejo',
			'Medellin',
			'Mendez',
			'Mendiola',
			'Mendoza',
			'Meneses',
			'Mercado',
			'Merete',
			'Miciano',
			'Millanes',
			'Mijares',
			'Miranda',
			'Moit',
			'Mollena',
			'Molina',
			'Moser',
			'Montefalco',
			'Montemayor',
			'Montes',
			'More',
			'Moreno',
			'Muñoz',
			'Meriño',
			'Morin',
			'Nacional',
			'Navarro',
			'Nebres',
			'Nemeño',
			'Nepomuceno',
			'Nesperos',
			'Nicol',
			'Nicolas',
			'Nieva',
			'Niperos',
			'Nofuente',
			'Nolasco',
			'Noriega',
			'Negranza',
			'Natividad',
			'Odi',
			'Olarte',
			'Olivares',
			'Ong',
			'Ordonez',
			'Ortega',
			'Olimberio',
			'Olesco',
			'Oranza',
			'Ohiman',
			'Oliveros',
			'Orocay',
			'Pablo',
			'Pagador',
			'Palomique',
			'Pandak',
			'Pangan',
			'Panganiban',
			'Pangilinan',
			'Pascual',
			'Paulino',
			'Pecson',
			'Pelaez',
			'Peralta',
			'Perez',
			'Pineda',
			'Pilota',
			'Poblete',
			'Ponce',
			'Portugal',
			'Posadas',
			'Prado',
			'Prieto',
			'Pesquisa',
			'Que',
			'Quezon',
			'Quiambao',
			'Quintana',
			'Quisumbing',
			'Quizon',
			'Rabanera',
			'Ramirez',
			'Ramiscal',
			'Ramoran',
			'Ranches',
			'Regaspi',
			'Resoles',
			'Retamar',
			'Retome',
			'Reynon',
			'Reyes',
			'Riego',
			'Ricaforte',
			'Ricarte',
			'Rio',
			'Rioflorido',
			'Robles',
			'Roces',
			'Rodriguez',
			'Romero',
			'Romulo',
			'Rola',
			'Rosales',
			'Rosario',
			'Roxas',
			'Rubia',
			'Rubio',
			'Roldan',
			'Salamaca',
			'Salameño',
			'Salameña',
			'Salonga',
			'Saldua',
			'Salvidar',
			'Sanchez',
			'Sangcap',
			'Santos',
			'Samoy',
			'Sauro',
			'Silonga',
			'Santa Maria',
			'Sta. Maria',
			'Santiago',
			'See',
			'Sevilla',
			'Sia',
			'Soberano',
			'Soledad',
			'Solis',
			'Sonon',
			'Soriano',
			'Sotto',
			'Suan',
			'Suarez',
			'Sy',
			'Salinas',
			'Tababa',
			'Tacurda',
			'Tran',
			'Tizon',
			'Tabinas',
			'Tolentino',
			'Toralba',
			'Tulfo',
			'Ubalde',
			'Ubaldo',
			'Umali',
			'Ungson',
			'Untalan',
			'Urrutia',
			'Valenzuela',
			'Valdez',
			'Velasco',
			'Velasquez',
			'Venigas',
			'Venosa',
			'Vicedo',
			'Vicente',
			'Villamor',
			'Viray',
			'Villareal',
			'Villaluz',
			'Villanueva',
			'Villapando',
			'Verceluz',
			'Veluz',
			'Vilar',
			'Waring',
			'Yabut',
			'Yacapin',
			'Yadao',
			'Yalung',
			'Yasay',
			'Ynares',
			'Ysip',
			'Zabala',
			'Zaldua',
			'Zamora',
			'Zapanta',
			'Zapata',
			'Zaragoza',
			'Zarate',
		);

		$random = $names[mt_rand(0, sizeof($names) - 1)];
		return $random;
	}

	public function phone()
	{
		$n = array(
			'0913',
			'0918',
			'0947',
			'0998',
			'0999',
			'0913',
			'0947',
			'0998',
			'0907',
			'0908',
			'0909',
			'0910',
			'0912',
			'0919',
			'0921',
			'0928',
			'0929',
			'0948',
			'0949',
			'0989',
			'0939',
			'0939',
			'0930',
			'0920',
			'0946',
			'0946',
			'0917',
			'0917',
			'0994',
			'0994',
			'0905',
			'0906',
			'0915',
			'0916',
			'0925',
			'0926',
			'0927',
			'0935',
			'0936',
			'0937',
			'0996',
			'0997',
			'0917',
			'0925',
			'0917',
			'0922',
			'0923',
			'0932',
			'0933',
			'0934',
			'0942',
			'0943',
			'0934',
			'0977',
			'0979',
			'0977',
			'0973',
			'0974',
		);
		$random = $n[mt_rand(0, sizeof($n) - 1)];
		$mid = mt_rand(100, 999);
		$last = mt_rand(1000, 9999);
		$phoneNumber = $random.$mid.$last;
		if(Student::where('contact_number', $phoneNumber)->exists()){
			return $this->phone();
		}
		return $phoneNumber;

	}

}
