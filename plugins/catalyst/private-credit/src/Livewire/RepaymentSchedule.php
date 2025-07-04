<?php

namespace Catalyst\PrivateCredit\Livewire;

use Livewire\Component;
use Carbon\Carbon;

class RepaymentSchedule extends Component
{
    public ?float $principal_amount;
    public ?float $interest_rate;
    public ?int $loan_duration;
    public ?string $duration_period;
    public ?string $repayment_cycle;
    public ?string $loan_release_date;

    public function render()
    {
        return view('private-credit::livewire.repayment-schedule');
    }

    public function getScheduleProperty()
    {
        $principal = $this->principal_amount;
        $interestRate = $this->interest_rate / 100;
        $duration = $this->loan_duration;
        $releaseDate = Carbon::parse($this->loan_release_date);

        if ($principal <= 0 || $interestRate < 0 || $duration <= 0) return [];

        $totalInterest = $principal * $interestRate;
        $totalLoanAmount = $principal + $totalInterest;

        // Determine the end date of the loan
        $endDate = $releaseDate->copy();

        match ($this->duration_period) {
            'days' => $endDate->addDays($duration),
            'weeks' => $endDate->addWeeks($duration),
            'months' => $endDate->addMonths($duration),
            'years' => $endDate->addYears($duration)
        };

        if ($this->repayment_cycle === 'once') return [[
            'due_date' => $endDate->format('d M Y'),
            'repayment' => number_format($totalLoanAmount, 2),
            'principal' => number_format($principal, 2),
            'interest' => number_format($totalInterest, 2),
            'balance' => number_format(0, 2),
        ]];

        $installments = $this->getInstallmentsCount($releaseDate, $endDate, $this->repayment_cycle);

        if ($installments == 0) return [];

        $installmentAmount = $totalLoanAmount / $installments;
        $principalPerInstallment = $principal / $installments;
        $interestPerInstallment = $totalInterest / $installments;

        $currentDate = $releaseDate->copy();
        $balance = $totalLoanAmount;
        $schedule = [];

        for ($i = 1; $i <= $installments; $i++) {
            $currentDate = $this->getNextDueDate($currentDate, $this->repayment_cycle);
            $balance -= $installmentAmount;

            $schedule[] = [
                'due_date' => $currentDate->format('d M Y'),
                'repayment' => number_format($installmentAmount, 2),
                'principal' => number_format($principalPerInstallment, 2),
                'interest' => number_format($interestPerInstallment, 2),
                'balance' => number_format($balance, 2),
            ];
        }

        return $schedule;
    }

    private function getInstallmentsCount(Carbon $startDate, Carbon $endDate, $repaymentCycle)
    {
        $count = 0;
        $currentDate = $startDate->copy();

        while ($currentDate->lessThan($endDate)) {
            $currentDate = $this->getNextDueDate($currentDate, $repaymentCycle);
            if ($currentDate->lessThanOrEqualTo($endDate)) $count++;
        }

        return $count;
    }


    private function getNextDueDate(Carbon $date, $cycle)
    {
        $new_date = $date->copy();

        $next_due_date = match ($cycle) {
            'daily' => $new_date->addDay(),
            'weekly' => $new_date->addWeek(),
            'bi-weekly' => $new_date->addWeeks(2),
            'monthly' => $new_date->addMonth(),
            'quarterly' => $new_date->addMonths(3),
            'semi-annual' => $new_date->addMonths(6),
            'per-year' => $new_date->addYear(),
            'once' => $new_date,
            default => $new_date,
        };

        return $next_due_date;
    }
}
