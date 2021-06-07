<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>Hello, world!</title>
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

    </style>


</head>

<body>

    <main>
        <div class="container py-4">
            <header class="pb-3 mb-4 border-bottom">
                <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                    <span class="fs-4">Address API Server</span>
                </a>
            </header>

            <div class="p-5 mb-4 bg-light rounded-3">
                <div class="container-fluid py-5">
                    <h1 class="display-5 fw-bold">Address API Server</h1>
                    <h2>Welcome!</h2>
                    <p class="col-md-8 fs-4">Acho que você abriu essa página por engano. Isso é uma API server.</p>
                    <p class="col-md-8 fs-4">Que tal testar como tal? <a href="#exemplos"
                            class="btn btn-primary btn-sm">Ver exemplos</a> </p>
                    <a class="btn btn-outline-primary btn-md"
                        href="https://github.com/tiagofrancafernandes/teste-api-enderecos" target="_blank">Repositório
                        deste projeto</a>
                </div>
            </div>

            <div class="row align-items-md-stretch">
                <div class="col-12">
                    <div class="h-100 p-5 bg-light border rounded-3">
                        <div class="container" id="exemplos">
                            <h5>Exemplos</h5>
                                @if ($random_address)
                                <ul>
                                    <li>
                                        <a class="btn btn-outline-primary btn-sm my-2" target="_blank" href="{{ route('address_by_cep', $random_address->cep) }}">
                                            Endereço por CEP na base {{ $random_address->cep }}
                                        </a>
                                    </li>

                                    <li>
                                        <a class="btn btn-outline-primary btn-sm my-2" target="_blank" href="{{ route('address_by_cep', $random_address->cep) }}">
                                            Endereço por CEP na base {{ $random_address->cep }}
                                        </a>
                                    </li>

                                    <li>
                                        <a class="btn btn-outline-primary btn-sm my-2" target="_blank" href="{{ route('address_by_cep', '81010250') }}">
                                            Endereço por CEP que NÃO existe originalmente na base
                                        </a>
                                    </li>

                                    <li>
                                        <a class="btn btn-outline-primary btn-sm my-2">A second item</a>
                                    </li>



                                </ul>
                                @endif
                        </div>
                    </div>
                </div>
            </div>

            <footer class="pt-3 mt-4 text-muted border-top">
                &copy; 2021 | Repositório deste projeto:
                <a href="https://github.com/tiagofrancafernandes/teste-api-enderecos"
                    target="_blank">https://github.com/tiagofrancafernandes/teste-api-enderecos</a>
            </footer>
        </div>
    </main>

</body>

</html>
