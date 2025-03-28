<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">

```text/plain
Directory structure:
└── djayi-atlas/
    ├── README.md
    ├── artisan
    ├── composer.json
    ├── composer.lock
    ├── package.json
    ├── phpunit.xml
    ├── postcss.config.js
    ├── tailwind.config.js
    ├── vite.config.js
    ├── .editorconfig
    ├── .env.example
    ├── app/
    │   ├── Casts/
    │   │   ├── HasAgreement.php
    │   │   ├── InternalizationAtHome.php
    │   │   ├── Location.php
    │   │   └── Modality.php
    │   ├── Enums/
    │   │   ├── AgreementActivityEnum.php
    │   │   ├── AgreementTypeEnum.php
    │   │   ├── HasAgreementEnum.php
    │   │   ├── InternationalizationAtHomeEnum.php
    │   │   ├── LocationEnum.php
    │   │   └── ModalityEnum.php
    │   ├── Http/
    │   │   ├── Controllers/
    │   │   │   ├── ActivityController.php
    │   │   │   ├── AgreementController.php
    │   │   │   ├── AssistanceController.php
    │   │   │   ├── CareerController.php
    │   │   │   ├── CertificateController.php
    │   │   │   ├── CityController.php
    │   │   │   ├── Controller.php
    │   │   │   ├── CountryController.php
    │   │   │   ├── EventController.php
    │   │   │   ├── FacultyController.php
    │   │   │   ├── FinancialEntityController.php
    │   │   │   ├── MovilityController.php
    │   │   │   ├── PersonController.php
    │   │   │   ├── ProfileController.php
    │   │   │   ├── StateController.php
    │   │   │   ├── UniversityController.php
    │   │   │   └── Auth/
    │   │   │       ├── AuthenticatedSessionController.php
    │   │   │       ├── ConfirmablePasswordController.php
    │   │   │       ├── EmailVerificationNotificationController.php
    │   │   │       ├── EmailVerificationPromptController.php
    │   │   │       ├── NewPasswordController.php
    │   │   │       ├── PasswordController.php
    │   │   │       ├── PasswordResetLinkController.php
    │   │   │       ├── RegisteredUserController.php
    │   │   │       └── VerifyEmailController.php
    │   │   └── Requests/
    │   │       ├── ProfileUpdateRequest.php
    │   │       └── Auth/
    │   │           └── LoginRequest.php
    │   ├── Jobs/
    │   │   └── SendCertificateEmailJob.php
    │   ├── Models/
    │   │   ├── Activity.php
    │   │   ├── Agreement.php
    │   │   ├── Assistance.php
    │   │   ├── Career.php
    │   │   ├── City.php
    │   │   ├── Country.php
    │   │   ├── Event.php
    │   │   ├── Faculty.php
    │   │   ├── FinancialEntity.php
    │   │   ├── Movility.php
    │   │   ├── Person.php
    │   │   ├── State.php
    │   │   ├── University.php
    │   │   └── User.php
    │   ├── Providers/
    │   │   ├── AppServiceProvider.php
    │   │   ├── CareerManagementServiceProvider.php
    │   │   ├── EventManagementServiceProvider.php
    │   │   └── UniversityManagementServiceProvider.php
    │   └── View/
    │       └── Components/
    │           ├── AppLayout.php
    │           └── GuestLayout.php
    ├── bootstrap/
    │   ├── app.php
    │   ├── providers.php
    │   └── cache/
    │       └── .gitignore
    ├── config/
    │   ├── app.php
    │   ├── auth.php
    │   ├── cache.php
    │   ├── database.php
    │   ├── filesystems.php
    │   ├── logging.php
    │   ├── mail.php
    │   ├── permission.php
    │   ├── queue.php
    │   ├── services.php
    │   └── session.php
    ├── database/
    │   ├── .gitignore
    │   ├── factories/
    │   │   └── UserFactory.php
    │   ├── migrations/
    │   │   ├── 0000_00_00_000000_create_countries_table.php
    │   │   ├── 0000_00_00_000001_create_states_table.php
    │   │   ├── 0000_00_00_000002_create_cities_table.php
    │   │   ├── 0000_00_00_000003_create_universities_table.php
    │   │   ├── 0000_00_00_000004_create_faculties_table.php
    │   │   ├── 0000_00_00_000005_create_careers_table.php
    │   │   ├── 0001_01_01_000000_create_cache_table.php
    │   │   ├── 0001_01_01_000001_create_permission_tables.php
    │   │   ├── 0001_01_01_000002_create_users_table.php
    │   │   ├── 0001_01_01_000003_create_jobs_table.php
    │   │   ├── 0002_02_00_000000_create_financial_entities_table.php
    │   │   ├── 0002_02_00_000001_create_agreements_table.php
    │   │   ├── 0002_02_00_000002_create_activities_table.php
    │   │   ├── 0002_02_00_000003_create_events_table.php
    │   │   ├── 0002_02_00_000004_create_mobilities_table.php
    │   │   ├── 0002_02_00_000005_create_people_table.php
    │   │   ├── 0002_02_00_000006_create_assistances_table.php
    │   │   └── 0002_02_00_000007_create_event_university_table.php
    │   └── seeders/
    │       └── DatabaseSeeder.php
    ├── lang/
    │   └── en/
    │       ├── auth.php
    │       ├── pagination.php
    │       ├── passwords.php
    │       └── validation.php
    ├── public/
    │   ├── index.php
    │   ├── robots.txt
    │   ├── .htaccess
    │   └── icons/
    ├── resources/
    │   ├── css/
    │   │   └── app.css
    │   ├── js/
    │   │   ├── app.js
    │   │   ├── bootstrap.js
    │   │   └── modules/
    │   │       └── utils/
    │   │           ├── conditionalSelect.js
    │   │           ├── dateValidation.js
    │   │           ├── filterSearch.js
    │   │           └── multiSelectUtil.js
    │   ├── lang/
    │   │   ├── en.json
    │   │   └── es.json
    │   └── views/
    │       ├── assistance.blade.php
    │       ├── index.blade.php
    │       ├── auth/
    │       │   ├── confirm-password.blade.php
    │       │   ├── forgot-password.blade.php
    │       │   ├── login.blade.php
    │       │   ├── register.blade.php
    │       │   ├── reset-password.blade.php
    │       │   └── verify-email.blade.php
    │       ├── components/
    │       │   ├── layouts/
    │       │   │   └── dashboard-layout.blade.php
    │       │   ├── modals/
    │       │   │   ├── create-activity-modal.blade.php
    │       │   │   ├── create-agreement-modal.blade.php
    │       │   │   ├── create-career-modal.blade.php
    │       │   │   ├── create-event-modal.blade.php
    │       │   │   └── create-university-modal.blade.php
    │       │   └── utils/
    │       │       └── language-selector.blade.php
    │       ├── dashboard/
    │       │   ├── index.blade.php
    │       │   └── pages/
    │       │       ├── activities/
    │       │       │   ├── edit.blade.php
    │       │       │   └── index.blade.php
    │       │       ├── agreements/
    │       │       │   ├── edit.blade.php
    │       │       │   └── index.blade.php
    │       │       ├── careers/
    │       │       │   ├── edit.blade.php
    │       │       │   └── index.blade.php
    │       │       ├── events/
    │       │       │   ├── edit.blade.php
    │       │       │   └── index.blade.php
    │       │       └── universities/
    │       │           ├── edit.blade.php
    │       │           └── index.blade.php
    │       ├── layouts/
    │       │   ├── app.blade.php
    │       │   ├── guest.blade.php
    │       │   └── navigation.blade.php
    │       ├── profile/
    │       │   ├── edit.blade.php
    │       │   └── partials/
    │       │       ├── delete-user-form.blade.php
    │       │       ├── update-password-form.blade.php
    │       │       └── update-profile-information-form.blade.php
    │       └── vendor/
    │           └── pagination/
    │               ├── bootstrap-4.blade.php
    │               ├── bootstrap-5.blade.php
    │               ├── default.blade.php
    │               ├── semantic-ui.blade.php
    │               ├── simple-bootstrap-4.blade.php
    │               ├── simple-bootstrap-5.blade.php
    │               ├── simple-default.blade.php
    │               ├── simple-tailwind.blade.php
    │               └── tailwind.blade.php
    ├── routes/
    │   ├── auth.php
    │   ├── console.php
    │   └── web.php
    ├── storage/
    │   ├── cacert.pem
    │   ├── app/
    │   │   ├── .gitignore
    │   │   ├── private/
    │   │   │   └── .gitignore
    │   │   └── public/
    │   │       └── .gitignore
    │   ├── framework/
    │   │   ├── .gitignore
    │   │   ├── cache/
    │   │   │   ├── .gitignore
    │   │   │   └── data/
    │   │   │       └── .gitignore
    │   │   ├── sessions/
    │   │   │   └── .gitignore
    │   │   ├── testing/
    │   │   │   └── .gitignore
    │   │   └── views/
    │   │       └── .gitignore
    │   └── logs/
    │       └── .gitignore
    └── tests/
        ├── Pest.php
        ├── TestCase.php
        ├── Feature/
        │   ├── ExampleTest.php
        │   ├── ProfileTest.php
        │   └── Auth/
        │       ├── AuthenticationTest.php
        │       ├── EmailVerificationTest.php
        │       ├── PasswordConfirmationTest.php
        │       ├── PasswordResetTest.php
        │       ├── PasswordUpdateTest.php
        │       └── RegistrationTest.php
        └── Unit/
            └── ExampleTest.php
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
