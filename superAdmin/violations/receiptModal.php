 <!-- Receipt Modal -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="receiptModalLabel">Official Receipt</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="receiptContent">
            <div style="text-align: center; margin-bottom: 20px;">
              <img src="../../assets/img/mtfrbLogo.png" alt="Logo1" style="height: 50px;">
              <h4>Municipal Tricycle Franchising Regulatory Board - Lucban</h4>
              <p>88 A. Racelis Ave, Lucban, Quezon</p>
            </div>
            <h5 style="text-align: center;">ORDER OF PAYMENT</h5>
            <hr>
            <p><strong>Ticket No:</strong> <span id="ticketNo"></span></p>
            <p><strong>Tricycle Franchise No:</strong> <span id="tfNo"></span></p>
            <p><strong>Date:</strong> <span id="date"></span></p>
            <p><strong>No. of Offense:</strong> <span id="offense"></span></p>
            <table class="table">
              <thead>
                <tr>
                  <th>Nature of Collection</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Violation</td>
                  <td id="amount"></td>
                </tr>
              </tbody>
            </table>
            <p><strong>Total:</strong> <span id="total"></span></p>
            <p><strong>Amount in Words:</strong> <span id="amountInWords"></span></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="saveReceiptAsImage()">Save as Image</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>