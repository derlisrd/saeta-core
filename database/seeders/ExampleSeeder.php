<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Cliente;
use App\Models\Deposito;
use App\Models\Empresa;
use App\Models\FormasPago;
use App\Models\Impuesto;
use App\Models\Medida;
use App\Models\Moneda;
use App\Models\Option;
use App\Models\Permiso;
use App\Models\PermisosOtorgado;
use App\Models\Sucursal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run($user, $nombreEmpresa): void
    {
        $this->createTaxes();
        $this->createDefaultCategory();
        $this->createDefaultClient();
        $this->createDefaultUnitOfMeasure();

        $empresa = $this->createCompany($nombreEmpresa);
        $sucursal = $this->createBranch($empresa);
        $this->createWarehouse($sucursal);
        $this->createPaymentMethods();
        $this->createUsers($user, $empresa, $sucursal);
        $this->createPermissions();
        $this->createDefaultCurrency();
        $this->createOptions($nombreEmpresa);
    }

    /**
     * Create default tax rates.
     */
    private function createTaxes(): void
    {
        Impuesto::firstOrCreate(['descripcion' => 'Exenta'], ['valor' => 0, 'porcentaje' => '0%']);
        Impuesto::firstOrCreate(['descripcion' => '5%'], ['valor' => 5, 'porcentaje' => '5%']);
        Impuesto::firstOrCreate(['descripcion' => '10%'], ['valor' => 10, 'porcentaje' => '10%']);
    }

    /**
     * Create default category.
     */
    private function createDefaultCategory(): void
    {
        Category::firstOrCreate(['nombre' => 'Sin categoría', 'publicado' => 0]);
    }

    /**
     * Create default client.
     */
    private function createDefaultClient(): void
    {
        Cliente::firstOrCreate(['doc' => 'x'], [
            'nombres' => 'Sin nombre',
            'razon_social' => 'Sin nombre',
            'deletable' => false
        ]);
    }

    /**
     * Create default unit of measure.
     */
    private function createDefaultUnitOfMeasure(): void
    {
        Medida::firstOrCreate(['descripcion' => 'Unidad'], [
            'abreviatura' => 'u',
            'default' => true
        ]);
    }

    /**
     * Create the company.
     */
    private function createCompany(string $nombreEmpresa): Empresa
    {
        return Empresa::firstOrCreate(['nombre' => $nombreEmpresa], [
            'ruc' => '0000',
            'telefono' => 'x',
            'direccion' => 'direccion',
            'configurado' => 1,
            'licencia' => Carbon::now()->addDays(30),
        ]);
    }

    /**
     * Create the branch office.
     */
    private function createBranch(Empresa $empresa): Sucursal
    {
        return Sucursal::firstOrCreate(['empresa_id' => $empresa->id, 'numero' => 1], [
            'nombre' => 'Nombre sucursal',
            'descripcion' => 'Descripcion sucursal',
            'direccion' => 'direccion sucursal',
            'telefono' => '0000'
        ]);
    }

    /**
     * Create the default warehouse.
     */
    private function createWarehouse(Sucursal $sucursal): void
    {
        Deposito::firstOrCreate(['sucursal_id' => $sucursal->id, 'nombre' => 'Principal'], [
            'activo' => 1
        ]);
    }

    /**
     * Create default payment methods.
     */
    private function createPaymentMethods(): void
    {
        FormasPago::firstOrCreate(['tipo' => 1, 'condicion' => 'contado'], ['descripcion' => 'Efectivo']);
    }

    /**
     * Create initial users.
     */
    private function createUsers($user, Empresa $empresa, Sucursal $sucursal): void
    {
        User::firstOrCreate(['email' => $user->email], [
            'name' => $user->name,
            'username' => $user->email,
            'password' => $user->password,
            'empresa_id' => $empresa->id,
            'sucursal_id' => $sucursal->id,
            'tipo' => 10,
            'hidden' => 0
        ]);

        User::factory()->create([
            'name' => 'Mantenimiento',
            'username' => env('USER_SEED', 'user'),
            'email' => env('EMAIL_SEED', 'demo@demo.com'),
            'password' => env('PASSWORD_SEED', 123456),
            'empresa_id' => $empresa->id,
            'sucursal_id' => $sucursal->id,
            'tipo' => 10,
            'hidden' => 1
        ]);
    }

    /**
     * Create default permissions.
     */
    private function createPermissions(): void
    {
        $permiso = Permiso::firstOrCreate(['modulo' => 'Usuarios', 'accion' => 'Administrar usuarios']);
        PermisosOtorgado::firstOrCreate(['user_id' => 1, 'permiso_id' => $permiso->id], ['otorgado' => true]);
    }

    /**
     * Create default currency.
     */
    private function createDefaultCurrency(): void
    {
        Moneda::firstOrCreate(['nombre' => 'Guaraníes'], [
            'simbolo' => 'Gs',
            'default' => true
        ]);
    }

    /**
     * Create initial options.
     */
    private function createOptions(string $nombreEmpresa): void
    {
        $optionsData = [
            ['value' => $nombreEmpresa, 'key' => 'title'],
            ['value' => 'Tu tienda online', 'key' => 'descripcion'],
            ['value' => '1234567890', 'key' => 'telefono'],
            ['key' => 'whatsapp', 'value' => '000000'],
            ['value' => 'https://placehold.co/300x200/000000/FFFFFF/jpg', 'key' => 'logo'],
            ['value' => 'Paraguay', 'key' => 'direccion'],
        ];

        foreach ($optionsData as $option) {
            Option::firstOrCreate(['key' => $option['key']], $option);
        }
    }
}
