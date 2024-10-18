@extends('layout.main', ['title' => 'Template'])

@section('mainContent')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">

                    <h3>Vertical Layout with Navbar</h3>
                    <p class="text-subtitle text-muted">
                        Navbar will appear on the top of the page.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.html">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Layout Vertical Navbar
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Dummy Text</h4>
                </div>
                <div class="card-body">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. In
                        mollis tincidunt tempus. Duis vitae facilisis enim, at
                        rutrum lacus. Nam at nisl ut ex egestas placerat sodales id
                        quam. Aenean sit amet nibh quis lacus pellentesque venenatis
                        vitae at justo. Orci varius natoque penatibus et magnis dis
                        parturient montes, nascetur ridiculus mus. Suspendisse
                        venenatis tincidunt odio ut rutrum. Maecenas ut urna
                        venenatis, dapibus tortor sed, ultrices justo. Phasellus
                        scelerisque, nibh quis gravida venenatis, nibh mi lacinia
                        est, et porta purus nisi eget nibh. Fusce pretium vestibulum
                        sagittis. Donec sodales velit cursus convallis sollicitudin.
                        Nunc vel scelerisque elit, eget facilisis tellus. Donec id
                        molestie ipsum. Nunc tincidunt tellus sed felis vulputate
                        euismod.
                    </p>

                </div>
            </div>
        </section>
    </div>
@endsection
