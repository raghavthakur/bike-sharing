CREATE VIEW CustRep_Rider_View(RIDER_ID, WALLET_ID, NAME, PHONE_NUM, EMAIL, ADDRESS, ECOINS, NUM_MAINTAIN_ISSUES, NUM_COMPLAINTS)
  AS
    SELECT R.RIDER_ID,
           R.WALLET_ID,
           R.NAME,
           R.PHONE_NUM,
           R.EMAIL,
           R.ADDRESS,
           R.ECOINS,
           COUNT(MI.RIDER_ID),
           COUNT(C.RIDER_ID)
    FROM RIDER R FULL
           JOIN MAINTENANCE_ISSUE MI ON R.RIDER_ID = MI.RIDER_ID FULL
           JOIN COMPLAINT C ON C.RIDER_ID = R.RIDER_ID
    GROUP BY R.RIDER_ID, R.WALLET_ID, R.NAME, R.PHONE_NUM, R.EMAIL, R.ADDRESS, R.ECOINS;

CREATE VIEW Rider_Bike_View(bike_ID, latitude, longitude)
  AS
    SELECT bike_ID, latitude, longitude
    FROM Bike b
    WHERE b.is_broken = 'Y';

COMMIT;