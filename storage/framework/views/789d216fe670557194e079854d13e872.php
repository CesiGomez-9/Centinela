<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Servicio</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4 bg-light">
<nav class="navbar navbar-expand-lg" style="background-color: #0A1F44; padding-top: 1.2rem; padding-bottom: 1.2rem; font-family: 'Courier New', sans-serif;">
    <div class="container" style="max-width: 1600px;">
        <a class="navbar-brand text-white fw-bold" href="#">
            <img src="<?php echo e(asset('seguridad/GrupoCentinela.jpg')); ?>" style="height:80px; margin-right: 10px;">
            Grupo Centinela
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link text-white" href="#">Registrate</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Servicios</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Nosotros</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>


<div class="container bg-white p-5 rounded shadow">
    <h2 class="mb-4">Editar Servicio</h2>

    <form action="<?php echo e(route('servicios.update', $servicios->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="row mb-3">
            <div class="col">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo e($servicios->nombre); ?>" required>
            </div>
            <div class="col">
                <label>Categoría</label>
                <input type="text" name="categoria" class="form-control" value="<?php echo e($servicios->categoria); ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Marca</label>
                <input type="text" name="marca" class="form-control" value="<?php echo e($servicios->marca); ?>" required>
            </div>
            <div class="col">
                <label>Modelo</label>
                <input type="text" name="modelo" class="form-control" value="<?php echo e($servicios->modelo); ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control"><?php echo e($servicios->descripcion); ?></textarea>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Código Interno</label>
                <input type="text" name="codigo_interno" class="form-control" value="<?php echo e($servicios->codigo_interno); ?>" required>
            </div>
            <div class="col">
                <label>Fecha de Ingreso</label>
                <input type="date" name="fecha_ingreso" class="form-control" value="<?php echo e($servicios->fecha_ingreso); ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Proveedor</label>
                <input type="text" name="proveedor" class="form-control" value="<?php echo e($servicios->proveedor); ?>">
            </div>
            <div class="col">
                <label>Precio de Compra</label>
                <input type="number" step="0.01" name="precio_compra" class="form-control" value="<?php echo e($servicios->precio_compra); ?>" required>
            </div>
            <div class="col">
                <label>Precio de Venta</label>
                <input type="number" step="0.01" name="precio_venta" class="form-control" value="<?php echo e($servicios->precio_venta); ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Unidades en Stock</label>
            <input type="number" name="unidades_stock" class="form-control" value="<?php echo e($servicios->unidades_stock); ?>" required>
        </div>

        <div class="d-flex justify-content-center gap-3">
            <button type="submit" class="btn btn-outline-success">Actualizar</button>
            <a href="<?php echo e(route('servicios.catalogo')); ?>" class="btn btn-outline-secondary">Cancelar</a>
        </div>

    </form>
</div>

</body>
</html>
<?php /**PATH C:\Users\Admin\PhpstormProjects\Centinela\resources\views/servicios/editar.blade.php ENDPATH**/ ?>