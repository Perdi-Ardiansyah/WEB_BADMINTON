# TODO: Change Dashboard Data Source to Riwayat Reservasi

## Completed Tasks
- [x] Add getReservasiAdmin method to RiwayatReservasiModel with alias for username
- [x] Update Dashboard controller to use RiwayatReservasiModel instead of ReservasiModel
- [x] Change the model instantiation in the constructor

## Summary
The dashboard now retrieves reservation data from the 'riwayat_reservasi' table instead of the 'reservasi' table. The RiwayatReservasiModel has been updated with a getReservasiAdmin method that aliases 'nama_user' as 'username' to match the view's expectations.
