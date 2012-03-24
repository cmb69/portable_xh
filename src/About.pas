unit About;

// http://www.swissdelphicenter.ch/de/showcode.php?id=1049

interface

uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  StdCtrls, ComCtrls;

type
  TAboutDialog = class(TForm)
    RichEdit1: TRichEdit;
    procedure FormShow(Sender: TObject);
  private
    { Private-Deklarationen }
  public
    { Public-Deklarationen }
  end;

var
  AboutDialog: TAboutDialog;

implementation

{$R *.DFM}
{$R AboutDoc.RES}

procedure TAboutDialog.FormShow(Sender: TObject);
var rs: TResourceStream;
begin
  rs := TResourceStream.Create(hinstance, 'ABOUTDOC', RT_RCDATA);
  try
    rs.Position := 0;
    Richedit1.Lines.LoadFromStream(rs);
  finally
    rs.Free;
  end;
end;

end.
