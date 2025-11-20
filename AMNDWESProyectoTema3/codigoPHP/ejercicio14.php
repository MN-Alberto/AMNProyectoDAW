<?php
// Se define una clase llamada operacionesBasicas
// que contiene métodos estáticos para realizar operaciones matemáticas simples.
class operacionesBasicas {

    // Método estático para sumar dos números.
    // Al ser estático, se puede llamar sin crear una instancia de la clase.
    // $num1 y $num2 son los parámetros que se sumarán.
    public static function sumarDosNumeros($num1, $num2){
        return $num1 + $num2; // Devuelve la suma de los dos números.
    }
    
    // Método estático para restar dos números.
    // Devuelve la diferencia: $num1 - $num2.
    public static function restarDosNumeros($num1, $num2){
        return $num1 - $num2;
    }
    
    // Método estático para multiplicar dos números.
    // Devuelve el producto: $num1 * $num2.
    public static function multiplicarDosNumeros($num1, $num2){
        return $num1 * $num2;
    }
    
    // Método estático para dividir dos números.
    // Devuelve el cociente: $num1 / $num2.
    public static function dividirDosNumeros($num1, $num2){
        return $num1 / $num2;
    }
}
?>