CREATE TABLE [dbo].[PreviousTrips] (
    [email]        VARCHAR (40) NOT NULL,
    [destination]  VARCHAR (30) NULL,
    [lengthOfTrip] TIME (7)     NULL,
    [dateOfTrip]   DATE         NOT NULL,
    PRIMARY KEY CLUSTERED ([email] ASC, [dateOfTrip] ASC),
    CONSTRAINT [Users_FK] FOREIGN KEY ([email]) REFERENCES [dbo].[Users] ([email])
);

