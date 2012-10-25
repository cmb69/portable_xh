unit MainForm;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, process, FileUtil, Forms, Controls, Graphics, Dialogs,
  ExtCtrls, Menus, AsyncProcess;

type

  { TfrmMain }

  TfrmMain = class(TForm)
    AsyncProcess1: TAsyncProcess;
    AsyncProcess2: TAsyncProcess;
    MenuItem1: TMenuItem;
    MenuItemClose: TMenuItem;
    MenuItemAbout: TMenuItem;
    MenuItemOpen: TMenuItem;
    popTray: TPopupMenu;
    Process1: TProcess;
    TrayIcon: TTrayIcon;
    procedure FormClose(Sender: TObject; var CloseAction: TCloseAction);
    procedure FormShow(Sender: TObject);
    procedure MenuItemAboutClick(Sender: TObject);
    procedure MenuItemCloseClick(Sender: TObject);
    procedure MenuItemOpenClick(Sender: TObject);
  private
    { private declarations }
  public
    { public declarations }
  end;

var
  frmMain: TfrmMain;

implementation

uses AboutForm, LCLIntf, DefaultTranslator;

{$R *.lfm}

{ TfrmMain }

procedure TfrmMain.MenuItemOpenClick(Sender: TObject);
begin
  OpenURL('http://localhost:8080')
end;

procedure TfrmMain.MenuItemCloseClick(Sender: TObject);
begin
  Close
end;

procedure TfrmMain.MenuItemAboutClick(Sender: TObject);
begin
  frmAbout.Show
end;

procedure TfrmMain.FormShow(Sender: TObject);
begin
  Hide;
  try
    AsyncProcess1.Execute;
    AsyncProcess2.Execute;
  except
    ShowMessage('Cant start');
    Close
  end;
end;

procedure TfrmMain.FormClose(Sender: TObject; var CloseAction: TCloseAction);
begin
  try
    AsyncProcess2.Terminate(0);
  finally
    Process1.Execute;
  end;
  CloseAction := caFree
end;

end.

