import type { Metadata } from 'next';
import './globals.css';
import './placex.css';

export const metadata: Metadata = {
  title: 'PlaceX — Jobs, Property, Classifieds, Vehicles, Matrimonial',
  description: 'PlaceX — Discover real opportunities, verified listings and amazing deals in your city.',
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en" suppressHydrationWarning>
      <head>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossOrigin="anonymous" />
        <link
          href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700;800;900&display=swap"
          rel="stylesheet"
        />
        <link
          rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        />
        <link rel="stylesheet" href="/placex.css" />
      </head>
      <body suppressHydrationWarning>{children}</body>
    </html>
  );
}
