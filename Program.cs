using criselitocomic_backend;
using criselitocomic_backend.Repositories;
using Microsoft.Extensions.Options;

var builder = WebApplication.CreateBuilder(args);

// Add services to the container.

builder.Services.AddControllers();

var cloudinarySettings = builder.Configuration.GetSection("CloudinarySettings");
builder.Services.Configure<CloudinarySettings>(cloudinarySettings);
builder.Services.AddSingleton<CloudinarySettings>(sp =>
                sp.GetRequiredService<IOptions<CloudinarySettings>>().Value);

builder.Services.AddSingleton<ComicsRepository>(); 
var app = builder.Build();

// Configure the HTTP request pipeline.

app.UseHttpsRedirection();

app.UseAuthorization();

app.MapControllers();

app.Run();
