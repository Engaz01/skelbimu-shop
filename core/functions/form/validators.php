<?php
/**
 * Funkcija patikrina ar input'o laukelis nebuvo paliktas tuščias.
 *
 * Jeigu rasta tuščia vertė - input'o duomenų masyve 'error' indeksu įrašoma
 * kilusi klaida.
 * Funkcija klaidos atveju grąžina false, kitu - true.
 *
 * @param string $field_value išvalyto input'o vertė.
 * @param array $field vieno input'o duomenų masyvas.
 * @return bool
 */
function validate_field_not_empty(string $field_value, array &$field): bool
{
    if ($field_value === '') {
        $field['error'] = 'Paliktas neuzpildytas laukas';
        return false;
    } else return true;

}

/**
 * @param string $field_value
 * @param array $field
 * @return bool
 */
function validate_field_has_space(string $field_value, array &$field): bool
{
    if (strpos($field_value, ' ') === false && $field_value !== trim($field_value)) {
        $field['error'] = 'Lauke nepaliktas tarpas tarp vardo ir pavardes';
        return false;
    }

    return true;

}


/**
 *
 * f-cija tikrina ar ivesta daugiau nei parametruose paduotas minimalus skaicius
 * ir ne daugiau nei maximalus skaicius
 *
 * @param string $field_value
 * @param array $field
 * @param array $params
 * @return bool
 */
function validate_field_range(string $field_value, array &$field, array $params): bool
{
    if ($field_value <= $params['min'] || $field_value >= $params['max']) {
        $field['error'] = strtr('Turi irasyti skaicius nuo @min iki @max', [
            '@min' => $params['min'],
            '@max' => $params['max']
        ]);
        return false;
    }

    return true;
}

/**
 *
 * f-cija tikrina ar visi laukai ivesti vienodi,
 * jei ne - grazina false ir priraso klaida - input'o duomenų masyve 'error' indeksu
 *
 * @param array $form_values
 * @param array $form
 * @param array $params
 * @return bool
 */
function validate_field_match(array $form_values, array &$form, array $params): bool
{
    foreach ($params as $field_index) {
        if ($form_values[$params[0]] !== $form_values[$field_index]) {
            $form['fields'][$field_index]['error'] = strtr('Laukelis nesutampa su @laukas ', [
                '@laukas' => $form['fields'][$params[0]]['label']
            ]);

            return false;
        }
    }

    return true;
}

function validate_select($field_input, &$field): bool
{
    if (isset($field['options'][$field_input])) {
        return true;
    }

    $field['error'] = 'Neteisingai pasirinkote siuntima';

    return false;
}

function validate_email(string $field_input, array &$field): bool
{

    $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';

    if (!preg_match($regex, $field_input)) {
        $field['error'] = 'Neteisingai uzpildete el.pasto formata. Pvz.: test@email.com';
        return false;
    }

    return true;

}

function validate_is_number(string $field_input, array &$field): bool
{
    $field_values_array = str_split($field_input);

    foreach ($field_values_array as $value) {
        if (is_numeric($value)) {
            return true;
        }
    }

    $field['error'] = 'Turite panaudoti bent 1 skaiciu';

    return false;
}

function validate_number_of_symbols(string $field_input, array &$field, array $params): bool
{
    if (strlen($field_input) > $params['max']) {
        $field['error'] = strtr('Turi panaudoti iki @max simboliu', [
            '@max' => $params['max']
        ]);
        return false;
    }

    return true;
}


function validate_is_numeric(string $field_input, array &$field): bool
{
    if (is_numeric($field_input) && $field_input > 0) {
        return true;

    }
    $field['error'] = 'Naudok skaicius - uz zodi negyvensi';

    return false;
}


function validate_no_numbers(string $field_input, array &$field): bool
{
    $field_values_array = str_split($field_input);

    foreach ($field_values_array as $value) {
        if (!is_numeric($value)) {
            return true;
        }
    }

    $field['error'] = 'Turite nenaudoti skaiciu';

    return false;
}