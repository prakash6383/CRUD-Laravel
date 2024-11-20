<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Trainee;
use App\Models\TechStack;
use App\Http\Controllers\TraineeController;
use Illuminate\Http\Request;

class TraineeTest extends TestCase
{
    use RefreshDatabase;

    // protected $seed = true;

    protected function setUp(): void
    {
        parent::setUp();

        // Disable CSRF verification for testing
        $this->withoutMiddleware();
    }

    /** @test */
    public function it_list_a_trainees()
    {
        Trainee::factory()->count(15)->create();

        $response = $this->get(route('trainees.index'));
        $response->assertSuccessful();
        $response->assertViewIs('index');
        $response->assertViewHas('trainees');
        $traineesInView = $response->viewData('trainees');

        $this->assertInstanceOf(LengthAwarePaginator::class, $traineesInView);
        $this->assertEquals(10, $traineesInView->perPage());
        $this->assertEquals(15, $traineesInView->total());
    }

    // /** @test */
    // public function it_list_a_trainees_through_the_controller()
    // {
    //     Trainee::factory()->count(15)->create();
    //     $request = new Request();
    //     $controller = new TraineeController();
    //     $response = $controller->index($request);

    //     $response = $this->get(route('trainees.index'));
    //     $response->assertSuccessful();
    //     $response->assertViewIs('index');
    //     $response->assertViewHas('trainees');
    //     $traineesInView = $response->viewData('trainees');

    //     $this->assertInstanceOf(LengthAwarePaginator::class, $traineesInView);
    //     $this->assertEquals(10, $traineesInView->perPage());
    //     $this->assertEquals(15, $traineesInView->total());
    // }

    /** @test */
    public function it_stores_a_trainee_through_the_controller()
    {
        $traineeData = Trainee::factory()->raw();
        $techStackData = TechStack::factory()->make()->toArray();
        $data = array_merge($traineeData, $techStackData);
        $request = new Request($data);
        $controller = new TraineeController();
        $response = $controller->store($request);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('trainees.index'), $response->headers->get('Location'));

        $newTrainee = Trainee::latest()->first();
        $this->assertDatabaseHas('trainees', [
            'firstName' => $newTrainee->firstName,
            'lastName' => $newTrainee->lastName,
            'email' => $newTrainee->email,
            'phone' => $newTrainee->phone,
            'role' => $newTrainee->role,
        ]);

        $this->assertDatabaseHas('tech_stacks', [
            'name' => $techStackData['name'],
            'status' => $techStackData['status'],
            'trainee_id' => $newTrainee->id,
        ]);
    }


    /** @test */
    public function it_stores_a_trainee_and_tech_stack()
    {
        $traineeData = Trainee::factory()->raw();
        $techStackData = TechStack::factory()->make()->toArray();
        $data = array_merge($traineeData, $techStackData);

        $response = $this->post(route('trainees.store'), $data);

        $response->assertStatus(302);
        $response->assertRedirect(route('trainees.index'));
        $response->assertSessionHas('success', 'Trainee has been created successfully.');
        $this->assertDatabaseHas('trainees', [
            'firstName' => $traineeData['firstName'],
            'lastName' => $traineeData['lastName'],
            'email' => $traineeData['email'],
            'phone' => $traineeData['phone'],
            'role' => $traineeData['role'],
        ]);

        $trainee = Trainee::latest()->first();
        $this->assertDatabaseHas('tech_stacks', [
            'name' => $techStackData['name'],
            'status' => $techStackData['status'],
            'trainee_id' => $trainee->id,
        ]);
    }

    /** @test */
    public function it_updates_a_trainee_with_tech_stack()
    {
        $trainee = Trainee::factory()->create([
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '1234567890',
            'role' => 'guest',
        ]);

        TechStack::factory()->create([
            'name' => 'laravel',
            'status' => 'active',
            'trainee_id' => $trainee->id
        ]);

        $updatedData = [
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            'email' => 'jane.doe@example.com',
            'phone' => '0987654321',
            'name' => 'php',
            'status' => 'inactive',
            'role' => 'admin',
        ];

        $response = $this->put(route('trainees.update', $trainee->id), $updatedData);

        $response->assertStatus(302);
        $response->assertRedirect(route('trainees.index'));
        $response->assertSessionHas('success', 'Trainee Has Been updated successfully');

        $updatedTrainee = Trainee::with('techStacks')->find($trainee->id);

        $this->assertEquals($updatedData['firstName'], $updatedTrainee->firstName);
        $this->assertEquals($updatedData['lastName'], $updatedTrainee->lastName);
        $this->assertEquals($updatedData['email'], $updatedTrainee->email);
        $this->assertEquals($updatedData['phone'], $updatedTrainee->phone);
        $this->assertEquals($updatedData['role'], $updatedTrainee->role);
        $this->assertEquals($updatedData['name'], $updatedTrainee->techStacks->name, 'Tech Stack Name did not update correctly');
        $this->assertEquals($updatedData['status'], $updatedTrainee->techStacks->status, 'Tech Stack Status did not update correctly');
    }

    /** @test */
    public function it_updates_a_trainee_through_the_controller()
    {
        $trainee = Trainee::factory()->create([
            'firstName' => 'Vijay',
            'lastName' => 'Antony',
            'email' => 'vijay.antony@example.com',
            'phone' => '1234567890',
            'role' => 'guest',
        ]);

        $trainee->techStacks()->create([
            'name' => 'laravel',
            'status' => 'active',
            'trainee_id' => $trainee->id
        ]);

        $updatedData = [
            'firstName' => 'Antony',
            'lastName' => 'Vijay',
            'email' => 'antony.vijay@example.com',
            'phone' => '0987654321',
            'name' => 'php',
            'status' => 'inactive',
            'role' => 'admin',
        ];

        $request = new Request($updatedData);

        $controller = new TraineeController();
        $response = $controller->update($request, $trainee->id);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertTrue(session()->has('success'));
        $this->assertEquals('Trainee Has Been updated successfully', session('success'));
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);

        $updatedTrainee = Trainee::with('techStacks')->find($trainee->id);

        $this->assertEquals($updatedData['firstName'], $updatedTrainee->firstName);
        $this->assertEquals($updatedData['lastName'], $updatedTrainee->lastName);
        $this->assertEquals($updatedData['email'], $updatedTrainee->email);
        $this->assertEquals($updatedData['phone'], $updatedTrainee->phone);
        $this->assertEquals($updatedData['role'], $updatedTrainee->role);
        $this->assertEquals($updatedData['name'], $updatedTrainee->techStacks->name);
        $this->assertEquals($updatedData['status'], $updatedTrainee->techStacks->status);
    }


    /** @test */
    public function it_deletes_a_trainee()
    {
        $trainee = Trainee::factory()->create();

        $response = $this->delete(route('trainees.destroy', $trainee->id));

        $response->assertRedirect(route('trainees.index'))
            ->assertSessionHas('success', 'Trainee has been deleted successfully');
        $this->assertDatabaseMissing('trainees', ['id' => $trainee->id]);
    }

    /** @test */
    public function it_deletes_a_trainee_through_the_controller()
    {
        $trainee = Trainee::factory()->create();
        $controller = new TraineeController();
        $response = $controller->destroy($trainee->id);

        // $response->assertSessionHas('success', 'Trainee has been deleted successfully');
        $this->assertDatabaseMissing('trainees', ['id' => $trainee->id]);
    }
}
