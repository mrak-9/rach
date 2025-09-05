<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\News;
use App\Models\Conference;
use App\Models\Branch;
use App\Models\Publication;
use App\Models\Project;
use App\Models\Partner;
use App\Models\Page;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем администратора
        $admin = User::updateOrCreate(
            ['email' => 'admin@ra.ru'],
            [
                'name' => 'Администратор РАЧ',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'phone' => '+7 (495) 123-45-67',
                'city' => 'Москва',
                'workplace' => 'Русская ассоциация чтения',
                'position' => 'Администратор',
                'academic_degree' => 'Кандидат педагогических наук',
                'membership_expires_at' => now()->addYear(),
            ]
        );

        // Создаем тестового пользователя
        $user = User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Иван Петров',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'phone' => '+7 (495) 987-65-43',
                'city' => 'Санкт-Петербург',
                'workplace' => 'СПбГУ',
                'position' => 'Доцент',
                'academic_degree' => 'Кандидат филологических наук',
                'membership_expires_at' => now()->addMonths(6),
            ]
        );

        // Создаем страницы
        Page::updateOrCreate(
            ['slug' => 'home'],
            [
                'title' => 'Главная страница',
                'content' => '<h2>Добро пожаловать в Русскую ассоциацию чтения</h2><p>Мы объединяем специалистов в области чтения, образования и грамотности для развития культуры чтения в России и за рубежом.</p>',
                'show_in_menu' => false,
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'О нас',
                'content' => '<h2>Русская ассоциация чтения</h2><p>Профессиональное объединение специалистов в области чтения и образования.</p>',
                'show_in_menu' => true,
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'membership'],
            [
                'title' => 'Членство в РАЧ',
                'content' => '<h2>Преимущества членства</h2><p>Участие в конференциях, доступ к публикациям, профессиональное развитие.</p>',
                'show_in_menu' => true,
            ]
        );

        // Создаем новости
        News::create([
            'title' => 'Открыта регистрация на ежегодную конференцию РАЧ 2024',
            'excerpt' => 'Приглашаем всех специалистов принять участие в главном событии года в области чтения и образования.',
            'content' => '<p>Русская ассоциация чтения объявляет о начале регистрации на ежегодную конференцию, которая состоится в мае 2024 года.</p><p>В программе конференции: пленарные доклады ведущих специалистов, секционные заседания, мастер-классы и круглые столы.</p>',
            'published_at' => now()->subDays(5),
            'is_published' => true,
        ]);

        News::create([
            'title' => 'Новое исследование о влиянии цифровых технологий на чтение',
            'excerpt' => 'Опубликованы результаты масштабного исследования влияния цифровых технологий на читательские навыки.',
            'content' => '<p>Исследование проводилось в течение двух лет и охватило более 5000 участников разных возрастных групп.</p><p>Основные выводы исследования будут представлены на предстоящей конференции.</p>',
            'published_at' => now()->subDays(10),
            'is_published' => true,
        ]);

        News::create([
            'title' => 'Подписано соглашение о международном сотрудничестве',
            'excerpt' => 'РАЧ подписала соглашение о сотрудничестве с Международной ассоциацией чтения.',
            'content' => '<p>Соглашение предусматривает обмен опытом, совместные исследования и участие в международных проектах.</p>',
            'published_at' => now()->subDays(15),
            'is_published' => true,
        ]);

        // Создаем конференции
        Conference::create([
            'title' => 'Ежегодная конференция РАЧ 2024: "Чтение в цифровую эпоху"',
            'announcement' => 'Главное событие года для специалистов в области чтения и образования.',
            'description' => '<p>Конференция посвящена актуальным вопросам развития чтения в условиях цифровизации образования.</p>',
            'registration_opens_at' => now()->subDays(30),
            'starts_at' => now()->addMonths(2),
            'ends_at' => now()->addMonths(2)->addDays(2),
            'location' => 'Москва, МГУ',
            'conference_type' => 'конференции',
            'is_active' => true,
        ]);

        Conference::create([
            'title' => 'Семинар "Современные методы обучения чтению"',
            'announcement' => 'Практический семинар для педагогов и специалистов.',
            'description' => '<p>Семинар включает практические занятия и мастер-классы по современным методикам обучения чтению.</p>',
            'registration_opens_at' => now()->subDays(15),
            'starts_at' => now()->addMonth(),
            'ends_at' => now()->addMonth()->addDay(),
            'location' => 'Санкт-Петербург',
            'conference_type' => 'семинаре',
            'is_active' => true,
        ]);

        // Создаем отделения
        Branch::create([
            'name' => 'Московское отделение РАЧ',
            'region' => 'Москва',
            'short_description' => 'Крупнейшее отделение ассоциации в столичном регионе.',
            'full_description' => '<p>Московское отделение объединяет более 200 специалистов из различных образовательных учреждений столицы.</p>',
            'phone' => '+7 (495) 123-45-67',
            'email' => 'moscow@ra-reading.ru',
            'address' => 'г. Москва, ул. Тверская, д. 1',
        ]);

        Branch::create([
            'name' => 'Санкт-Петербургское отделение РАЧ',
            'region' => 'Санкт-Петербург',
            'short_description' => 'Активное отделение в культурной столице России.',
            'full_description' => '<p>Отделение активно сотрудничает с ведущими университетами и библиотеками города.</p>',
            'phone' => '+7 (812) 987-65-43',
            'email' => 'spb@ra-reading.ru',
            'address' => 'г. Санкт-Петербург, Невский пр., д. 50',
        ]);

        // Создаем публикации
        Publication::create([
            'title' => 'Методика развития читательской грамотности',
            'short_description' => 'Практическое руководство для педагогов.',
            'description' => '<p>Подробное руководство по развитию читательской грамотности у учащихся разных возрастов.</p>',
            'published_at' => now()->subMonths(2),
            'requires_membership' => true,
        ]);

        // Создаем проекты
        Project::create([
            'title' => 'Цифровая библиотека для детей',
            'short_description' => 'Создание интерактивной цифровой библиотеки.',
            'description' => '<p>Проект направлен на создание современной цифровой библиотеки с интерактивными элементами для детей.</p>',
            'testing_by' => 'Московское отделение РАЧ, СПбГУ',
        ]);

        // Создаем партнеров
        Partner::create([
            'name' => 'Российская государственная библиотека',
            'short_description' => 'Крупнейшая библиотека России.',
            'description' => '<p>Стратегический партнер в области развития читательской культуры.</p>',
            'website_url' => 'https://www.rsl.ru',
        ]);

        $this->command->info('Тестовые данные созданы успешно!');
    }
}
