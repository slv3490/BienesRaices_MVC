<main class="contenedor seccion">
    <h1>Iniciar Session</h1>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" class="formulario" action="/login">
        <fieldset>
            <legend>Email y Password</legend>

            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Tu Email" id="email">

            <label for="password">Passwoard</label>
            <input type="password" name="password" placeholder="Tu password" id="password">

            <p>Credenciales</p>
            <ul class="credenciales">
                <li>Email: admin@admin.com</li>
                <li>Contraseña: administrador</li>
            </ul>
        </fieldset>
        <input type="submit" value="Iniciar Session" class="boton boton-verde">
    </form>
</main>