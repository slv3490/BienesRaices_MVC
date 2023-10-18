<fieldset>
    <legend>Informacion General</legend>

    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" placeholder="Nombre Vendedor" value="<?php echo s($vendedor->nombre) ?>">

    <label for="apellido">Apellido</label>
    <input type="text" name="apellido" id="apellido" placeholder="Apellido Vendedor" value="<?php echo s($vendedor->apellido) ?>">

    <label for="telefono">Telefono</label>
    <input type="number" name="telefono" id="telefono" placeholder="Telefono Vendedor" value="<?php echo s($vendedor->telefono) ?>">
</fieldset>