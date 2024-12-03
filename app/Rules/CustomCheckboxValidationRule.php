<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class CustomCheckboxValidationRule implements Rule
{
   
    protected $validCheckboxValues, $amountsArray;

    public function __construct(array $validCheckboxValues, array $amountsArray)
    {
        $this->validCheckboxValues = $validCheckboxValues; // Valid checkboxes value from database
        $this->amountsArray = $amountsArray; // valid amount inputs names

    }

    public function passes($attribute, $values)
    {
        // Check that at least one checkbox is checked
        if (count($values) > 0) {
            // Validate each checkbox value based on the validCheckboxValues array, and to check if checkbox value is numeric
            foreach ($values as $checkboxValue) {
                if (!in_array($checkboxValue, $this->validCheckboxValues) || !is_numeric($checkboxValue)) {
                    
                    return false; // Invalid checkbox value
                }
                // Validate the presence of the corresponding amount input
                $amountInputName = 'subscription_type_amount' . $checkboxValue;
                
                if (!in_array($amountInputName, $this->amountsArray)) {
                    // dd($amountInputName);
                    return false; // Corresponding amount input is missing
                }
            }
            // If all checks pass, return true
            return true;
        }

        return false;
    }
  
    public function message()
    {
        return 'At least one checkbox must be checked, and checked checkboxes must have valid values. Also, amounts must be filled and numeric.';
    }

}
