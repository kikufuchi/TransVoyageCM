<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="tools\bootstrap-5.3.8\css\bootstrap.min.css">
    <link rel="stylesheet" href="tools\vendor\fonts\css\all.min.css">
    <title>Tickets de bus TransVoyageCM</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f6f9;
            padding: 20px;
        }

        .ticket {
            background: white;
            border: none;
            border-radius: 12px;
            margin: 15px auto;
            max-width: 380px;
            page-break-after: always;
            overflow: hidden;
        }

        .ticket-header {
            background: linear-gradient(135deg, #2896a7, #2091c9);
            color: white;
            text-align: center;
            padding: 15px;
        }

        .ticket-header h3 {
            margin: 0;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .ticket-header small {
            opacity: 0.9;
            font-style: italic;
        }

        .ticket-body {
            padding: 15px 20px;
        }

        .ticket-body .info-ligne {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #e0e0e0;
        }

        .ticket-body .info-ligne:last-child {
            border-bottom: none;
        }

        .ticket-body .label {
            color: #6c757d;
            font-size: 13px;
        }

        .ticket-body .valeur {
            font-weight: bold;
            color: #2c3e50;
            text-align: right;
        }

        .ticket-footer {
            background: #f8f9fa;
            text-align: center;
            padding: 10px;
            font-size: 11px;
            color: #999;
            border-top: 1px solid #eee;
        }

        .numero-place {
            display: inline-block;
            background: #289aa7;
            color: white;
            width: 35px;
            height: 35px;
            line-height: 35px;
            text-align: center;
            border-radius: 50%;
            font-weight: bold;
            font-size: 16px;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            @page {
                size: A5;
                margin: 0.5cm;
            }

            .ticket {
                box-shadow: none !important;
                border: 2px dashed #000;
            }

            .ticket-header {
                background: linear-gradient(135deg, #2896a7, #2091c9);
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .numero-place {
                background: #289aa7;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>

    <div class="text-center no-print mb-3">
        <button onclick="window.print()" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-print me-2"></i> Imprimer les tickets
        </button>
        <p class="text-muted mt-2">
            <i class="fas fa-info-circle me-1"></i>
            Les tickets s'ouvriront en PDF
        </p>
    </div>

    <?php foreach ($passagers as $p) : ?>
        <div class="ticket shadow-sm">
            <div class="ticket-header">
                <h3><i class="fas fa-bus me-2"></i>TransVoyagesCM</h3>
                <small>Ticket de voyage officiel</small>
            </div>
            <div class="ticket-body">
                <div class="info-ligne">
                    <span class="label"><i class="fas fa-user me-2"></i>Passager</span>
                    <span class="valeur"><?= htmlspecialchars($p->nom_passager) ?></span>
                </div>
                <div class="info-ligne">
                    <span class="label"><i class="fas fa-id-card me-2"></i>CNI</span>
                    <span class="valeur"><?= htmlspecialchars($p->numero_CNI) ?></span>
                </div>
                <div class="info-ligne">
                    <span class="label"><i class="fas fa-chair me-2"></i>Place n°</span>
                    <span class="valeur">
                        <span class="numero-place"><?= htmlspecialchars($p->numeroChoisi) ?></span>
                    </span>
                </div>
                <div class="info-ligne">
                    <span class="label"><i class="fas fa-route me-2"></i>Voyage</span>
                    <span class="valeur"><?= htmlspecialchars($voyage->nom_voyage) ?></span>
                </div>
                <div class="info-ligne">
                    <span class="label"><i class="fas fa-tag me-2"></i>prix</span>
                    <span class="valeur"><?= htmlspecialchars($voyage->prix) ?></span>
                </div>
                <div class="info-ligne">
                    <span class="label"><i class="fas fa-bus me-2"></i>Bus</span>
                    <span class="valeur"><?= htmlspecialchars($bus->nom_bus ?? 'N/A') ?></span>
                </div>
                <div class="info-ligne">
                    <span class="label"><i class="fas fa-calendar-alt me-2"></i>Départ</span>
                    <span class="valeur">
                        <?= date('d/m/Y', strtotime($voyage->date_voyage)) ?>
                        <br><small class="text-muted">à <?= date('H:i', strtotime($voyage->heure_depart)) ?></small>
                    </span>
                </div>
            </div>
            <div class="ticket-qr text-center py-1">
                <div id="qrcode-<?= $p->id_passager ?>" class="d-inline-block"></div>
            </div>
            <div class="ticket-footer">
                Merci de votre confiance !
            </div>
        </div>
    <?php endforeach; ?>
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
</body>

<script>
    window.onload = function() {
        <?php foreach ($passagers as $p) : ?>
            new QRCode(document.getElementById("qrcode-<?= $p->id_passager ?>"), {
                text: "Passager: <?= $p->nom_passager ?>\nPlace: <?= $p->numeroChoisi ?>\nPrix: <?= $voyage->prix ?> FCFA",
                width: 120,
                height: 120,
                correctLevel:QRCode.CorrectLevel.L,
                colorDark: "#000000",
                colorLight: "#ffffff"
            });
        <?php endforeach; ?>
    };
</script>

</html>