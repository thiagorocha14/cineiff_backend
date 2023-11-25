<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SolicitacaoReservaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $inicio = fake()->dateTimeBetween('now', '+1 month');
        $fim = $inicio->add(new \DateInterval('PT1H'));
        return [
            'nome_evento' => fake()->name(),
            'justificativa' => fake()->text(),
            'instituicao' => fake()->name(),
            'publico_alvo' => fake()->name(),
            'inicio' => $inicio,
            'fim' => $fim,
            'nome_solicitante' => fake()->name(),
            'documento' => fake()->randomNumber(9),
            'telefone' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'descricao' => fake()->text(),
            'status' => fake()->randomElement(['pendente', 'deferido', 'indeferido']),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (\App\Models\SolicitacaoReserva $solicitacaoReserva) {
            if ($solicitacaoReserva->status == 'deferido') {
                $solicitacaoReserva->reserva()->create([
                    'inicio' => $solicitacaoReserva->inicio,
                    'fim' => $solicitacaoReserva->fim,
                    'status' => 'agendado',
                    'user_id' => 1,
                ]);
            }
        });
    }
}
